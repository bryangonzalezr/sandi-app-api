<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePortionRequest;
use App\Http\Requests\UpdatePortionRequest;
use App\Http\Resources\PortionResource;
use App\Models\Portion;
use Illuminate\Http\Request;

class PortionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $portions = Portion::when($request->filled('patient_id'), function ($query) use ($request) {
            $query->where('patient_id', $request->patient_id);
        })->get();

        return PortionResource::collection($portions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePortionRequest $request)
    {
        $portion = Portion::create($request->validated());

        return new PortionResource($portion);
    }

    /**
     * Display the specified resource.
     */
    public function show(Portion $portions)
    {
        return new PortionResource($portions);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePortionRequest $request, Portion $portion)
    {
        $portion->update($request->validated());
        return new PortionResource($portion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portion $portion)
    {
        //
    }
}
