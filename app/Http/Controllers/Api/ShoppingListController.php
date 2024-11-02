<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShoppingListRequest;
use App\Http\Resources\ShoppingListResource;
use App\Models\Menu;
use App\Models\ShoppingList;
use App\Observers\SupermarketCrawlerObserver;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Spatie\Crawler\Crawler;

class ShoppingListController extends Controller
{

    public function index()
    {
        $shopping_list = ShoppingList::all();

        return ShoppingListResource::collection($shopping_list);
    }

    public function store(StoreShoppingListRequest $request)
    {

    }

    public function show(ShoppingList $shopping_list)
    {
        return new ShoppingListResource($shopping_list);
    }
}
