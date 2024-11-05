<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommuneResource;
use App\Models\Commune;
use Illuminate\Http\Request;

class CommuneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $communes = Commune::with(['provinces', 'provinces.regions'])->when($request->filled('region'), function ($q) use ($request) {
            $q->whereHas('provinces', function ($q) use ($request) {
                $q->whereHas('regions', function ($q) use ($request) {
                    $q->where('ordinal', $request->input('region'));
                });
            });
        })->get();

        return CommuneResource::collection($communes);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Commune $commune)
    {
        return new CommuneResource($commune);
    }
}
