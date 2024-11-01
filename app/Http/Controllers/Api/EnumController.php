<?php

namespace App\Http\Controllers\Api;

use App\Enums\ExperienceType;
use App\Enums\Health;
use App\Http\Controllers\Controller;
use App\Http\Resources\EnumResource;
use Illuminate\Http\Request;

class EnumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function healthTypes()
    {
        $healthTypes = collect(Health::get())->sortBy('value')->map(function ($item, $key) {
            return (object) $item;
        });
        return EnumResource::collection($healthTypes);
    }

    public function experienceTypes()
    {
        $experienceTypes = ExperienceType::get();

        return EnumResource::collection($experienceTypes);
    }

}
