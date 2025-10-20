<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegionResource;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $regions = Region::when($request->filled('region'), function ($q) use ($request) {
            $q->where('ordinal', $request->region);
        })->get();

        return RegionResource::collection($regions);
    }

    /**
     * Display the specified resource.
     */
    public function show(Region $region)
    {
        return new RegionResource($region);
    }
}
