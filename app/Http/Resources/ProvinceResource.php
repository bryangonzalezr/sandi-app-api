<?php

namespace App\Http\Resources;

use App\Models\Province;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/** @mixin Province */class ProvinceResource extends JsonResource{
    public function toArray(Request $request): array
    {
        return [
//
        ];
    }
}
