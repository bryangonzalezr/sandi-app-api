<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDayMenuRequest;
use App\Http\Requests\UpdateDayMenuRequest;
use App\Models\DayMenu;

class DayMenuController extends Controller
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
    public function store(StoreDayMenuRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DayMenu $dayMenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDayMenuRequest $request, DayMenu $dayMenu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DayMenu $dayMenu)
    {
        //
    }
}
