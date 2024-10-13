<?php

namespace App\Http\Resources;

use App\Enums\Health;
use App\Helpers\TranslationHelper;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Recipe */
class RecipeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $dietLabels = TranslationHelper::translateCollection(collect($this->dietLabels));
        $mealType = TranslationHelper::translateCollection(collect($this->mealType));
        $dishType = TranslationHelper::translateCollection(collect($this->dishType));
        $healthLabels = TranslationHelper::translateCollection(collect($this->healthLabels));

        return [
            'label' => $this->label,
            'dietLabels' => $dietLabels,
            'healthLabels' => $healthLabels,
            'ingredientLines' => $this->ingredientLines,
            'calories' => $this->calories,
            'mealType' => $mealType,
            'dishType' => $dishType,
            'instructions' => $this->instructions,
            'user_id' => $this->user_id,
            'sandi_recipe' => $this->sandi_recipe
        ];
    }
}
