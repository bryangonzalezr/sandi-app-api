<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePortionRequest;
use App\Http\Resources\PortionResource;
use App\Models\Portion;
use Illuminate\Http\Request;

class PortionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Portion $portion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portion $portion)
    {
        //
    }
}
