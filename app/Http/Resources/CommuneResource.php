<?php

namespace App\Http\Resources;

use App\Models\Commune;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Commune */
class CommuneResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

        ];
    }
}
