<?php

namespace App\Http\Resources;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Region */
class RegionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

        ];
    }
}
