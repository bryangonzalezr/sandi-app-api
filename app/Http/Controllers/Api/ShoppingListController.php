<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShoppingListRequest;
use App\Http\Resources\ShoppingListResource;
use App\Jobs\ShoppingListJob;
use App\Models\DayMenu;
use App\Models\Menu;
use App\Models\ShoppingList;
use App\Models\User;
use App\Observers\SupermarketCrawlerObserver;
use Auth;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\Crawler\Crawler;

class ShoppingListController extends Controller
{

    public function index()
    {
        $user = User::with(['dayMenus','menus'])->where('id', Auth::id())->first();

        $shopping_list = ShoppingList::whereIn('menu_id', $user->dayMenus->pluck('_id'))->orWhere(function ($query) use ($user) {
            $query->whereIn('menu_id', $user->menus->pluck('_id'));
        })->orderBy('created_at','desc')->get();

        return ShoppingListResource::collection($shopping_list);
    }

    public function getProgress($menuId)
    {
        $progressKey = 'shopping_list_progress_' . $menuId;
        $data = Cache::get($progressKey);
        /* $progressData = [
            'progress' => 0,
            'status' => 'active'
        ]; */

        if ($data){
            if ($data['progress'] >= 100){
                $data = Cache::get($progressKey, [
                    'progress' => 100,
                    'status' => 'inactive'
                ]);
            }
            Cache::forget($progressKey);
        }

        return response()->json([
            'progress' => $data
        ]);
    }

    public function show($menuId)
    {
        $shopping_list = ShoppingList::with(['dayMenu', 'menu'])->where('menu_id', $menuId)->first();
        return new ShoppingListResource($shopping_list);
    }

    /* public function scrapping(DayMenu $dayMenu)
    {
        ShoppingListJob::dispatch(
            $dayMenu,
            $dayMenu->type
        )->onQueue('shoppingList');
    } */
}
