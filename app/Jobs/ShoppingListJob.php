<?php

namespace App\Jobs;

use App\Models\DayMenu;
use App\Models\ShoppingList;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ShoppingListJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $menu,
        public $menuType
    )
    {
        $this->menu = $menu;
        $this->menuType = $menuType;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{
            $list = [];
        $count_ingredients = [];
        $total_ingredients = 0;
        $processed_ingredients = 0;

        // Identificador único para el progreso
        $progressKey = 'shopping_list_progress_' . $this->menu->id;
        $progressData = [
            'progress' => 0,
            'status' => 'active'
        ];

        // Calcula el total de ingredientes para definir el progreso
        if ($this->menu->type == 'diario') {
            foreach ($this->menu->recipes as $recipe) {
                $total_ingredients += count($recipe["ingredients"]);
            }
        } else {
            foreach ($this->menu->menus as $day_menu) {
                foreach ($day_menu as $recipe) {
                    $total_ingredients += count($recipe["ingredients"]);
                }
            }
        }

        if ($this->menu->type == 'diario'){
            foreach($this->menu->recipes as $recipe){
                foreach($recipe["ingredients"] as $ingredient){
                    $formatted_ingredient = str_replace(' ','_',$ingredient);
                    if(array_key_exists($formatted_ingredient, $count_ingredients)){
                        $count_ingredients[$formatted_ingredient] += 1;
                        continue;
                    } else{
                        $scrape = $this->scrape($formatted_ingredient);
                        array_push($list, $scrape);
                        $count_ingredients[$formatted_ingredient] = 1;
                    }
                    // Incrementa el progreso y actualiza la cache
                    $processed_ingredients++;
                    $progress = ($processed_ingredients / $total_ingredients) * 100;
                    $progressData['progress'] = $progress;
                    $progressData['status'] = $progress >= 100 ? 'inactive' : 'active';
                    Cache::put($progressKey, $progressData, now()->addMinutes(10));
                }
            }
        } else{
            foreach($this->menu->menus as $day_menu){
                foreach($day_menu as $recipe){
                    foreach($recipe["ingredients"] as $ingredient){
                        $formatted_ingredient = str_replace(' ','_',$ingredient);
                        if(array_key_exists($formatted_ingredient, $count_ingredients)){
                            $count_ingredients[$formatted_ingredient] += 1;
                            continue;
                        } else{
                            $scrape = $this->scrape($formatted_ingredient);
                            array_push($list, $scrape);
                        }

                        // Incrementa el progreso y actualiza la cache
                        $processed_ingredients++;
                        $progress = ($processed_ingredients / $total_ingredients) * 100;
                        $progressData['progress'] = $progress;
                        $progressData['status'] = $progress >= 100 ? 'inactive' : 'active';
                        Cache::put($progressKey, $progressData, now()->addMinutes(10));

                    }
                }
            }
        }


        // Una vez terminado el trabajo, marca como "completado"


        $shopping_list = ShoppingList::updateOrCreate([
            'menu_id' => $this->menu->id,
        ],[
            'list'    => $list,
            'amounts' => $count_ingredients,
            'menu_type' => $this->menuType
        ]);

        } catch (Exception $error) {
            $progressData['status'] = 'failed';
            Cache::put($progressKey, $progressData, now()->addMinutes(10));
            Cache::forget($progressKey);
            logger($error);
        }

    }

    private function scrape($ingredient)
    {
        $scrapper_path = app_path('Scripts/scrapper') . '/scrapper.py';
        $output = [];
        $response = exec('python3 ' . $scrapper_path . ' ' . $ingredient, $output);
        $response = explode(',', $response);

        if ($response[0] == 'error') {
            return response()->json([
                "message" => $response[1]
            ]);
        }elseif ($response[0] == 'ok') {
            return json_decode($response[1]);
        }
    }
}
