<?php

namespace App\Jobs;

use App\Models\DayMenu;
use App\Models\ShoppingList;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class ShoppingListJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $menu,
    )
    {
        $this->menu = $menu;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $list = [];
        $count_ingredients = [];
        $total_ingredients = 0;
        $processed_ingredients = 0;

        // Identificador único para el progreso
        $progressKey = 'shopping_list_progress_' . $this->menu->id;

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
                    Cache::put($progressKey, $progress, now()->addMinutes(10));
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
                        Cache::put($progressKey, $progress, now()->addMinutes(10));

                    }
                }
            }
        }

        Cache::forget($progressKey);

        $shopping_list = ShoppingList::create([
            'menu_id' => $this->menu->id,
            'list'    => $list,
            'amounts' => $count_ingredients
        ]);
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
