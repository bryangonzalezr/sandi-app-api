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
        public string $menuType,
        public string $action,
    )
    {
        $this->menu = $menu;
        $this->menuType = $menuType;
        $this->action = $action;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{
            $list = [];
            $total_ingredients = 0;
            $processed_ingredients = 0;

            // Identificador único para el progreso
            $progressKey = 'shopping_list_progress_' . $this->menu->id;
            $progressData = [
                'progress' => 0,
                'status' => 'active_' . $this->action
            ];

            // Calcula el total de ingredientes para definir el progreso
            if ($this->menu->type == 'diario') {
                foreach ($this->menu->recipes as $recipe) {
                    foreach($recipe["ingredients"] as $ingredient){
                        $total_ingredients += round($ingredient['quantity'], 0, PHP_ROUND_HALF_UP);
                    }
                }
            } else {
                foreach ($this->menu->menus as $day_menu) {
                    foreach ($day_menu as $recipe) {
                        $total_ingredients += count($recipe["ingredients"]);
                    }
                }
            }

            if ($this->menuType == 'diario'){
                foreach($this->menu->recipes as $recipe){
                    foreach($recipe["ingredients"] as $ingredient){
                        $formatted_ingredient = str_replace(' ','_',$ingredient['food']);
                        if(array_key_exists($formatted_ingredient, $list)){
                            $list[$formatted_ingredient]['amount'] = round($ingredient['quantity'], 0, PHP_ROUND_HALF_UP);
                        } else{
                            $scrape = $this->scrape($formatted_ingredient);
                            $list[$formatted_ingredient] = [
                                'price' => $scrape[$formatted_ingredient] ?? 'N/A',
                                'amount' => round($ingredient['quantity'], 0, PHP_ROUND_HALF_UP),
                            ];
                        }
                        // Incrementa el progreso y actualiza la cache
                        $processed_ingredients += round($ingredient['quantity'], 0, PHP_ROUND_HALF_UP);
                        $progress = round(($processed_ingredients / $total_ingredients) * 100,1, PHP_ROUND_HALF_UP);
                        $progressData['progress'] = $progress;
                        $progressData['status'] = $progress >= 100 ? 'inactive' : 'active_'. $this->action;
                        Cache::put($progressKey, $progressData, now()->addMinutes(10));
                    }
                }
            } else{
                foreach($this->menu->menus as $day_menu){
                    foreach($day_menu as $recipe){
                        foreach($recipe["ingredients"] as $ingredient){
                            $formatted_ingredient = str_replace(' ','_',$ingredient['food']);
                            if(array_key_exists($formatted_ingredient, $list)){
                                $list[$formatted_ingredient]['amount'] = round($ingredient['quantity'], 0, PHP_ROUND_HALF_UP);
                                continue;
                            } else{
                                $list[$formatted_ingredient] = [
                                    'price' => $scrape[$formatted_ingredient] ?? 'N/A',
                                    'amount' => round($ingredient['quantity'], 0, PHP_ROUND_HALF_UP),
                                ];
                            }

                            // Incrementa el progreso y actualiza la cache
                            $processed_ingredients += round($ingredient['quantity'], 0, PHP_ROUND_HALF_UP);
                            $progress = ($processed_ingredients / $total_ingredients) * 100;
                            $progressData['progress'] = $progress;
                            $progressData['status'] = $progress >= 100 ? 'inactive' : 'active_'. $this->action;
                            Cache::put($progressKey, $progressData, now()->addMinutes(10));
                        }
                    }
                }

            }

            $shopping_list = ShoppingList::updateOrCreate([
                'menu_id' => $this->menu->id,
            ],[
                'list' => $list,
                'menu_type' => $this->menuType
            ]);

        } catch (Exception $error) {
            $progressData['status'] = 'failed_'. $this->action;
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
