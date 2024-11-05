<?php

namespace App\Console\Commands;

use App\Jobs\ShoppingListJob;
use App\Models\DayMenu;
use App\Models\Menu;
use Illuminate\Console\Command;

class TestShoppingList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:shopping {menuType} {menuId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $menuId = $this->argument('menuId');
        $menuType = $this->argument('menuType');
        if ($menuType == 'diario'){
            $menu = DayMenu::find($menuId);
        } else{
            $menu = Menu::find($menuId);
        }


        if (!$menu) {
            $this->error("Menu with ID {$menuId} not found.");
            return;
        }

        // Despacha el job
        ShoppingListJob::dispatch($menu, $menu->type)->onQueue('shoppingList');

        $this->info("ShoppingListJob for menu ID {$menuId} dispatched!");

    }
}
