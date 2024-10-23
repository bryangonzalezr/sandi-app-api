<?php

namespace App\Rules;

use App\Models\DayMenu;
use App\Models\Menu;
use App\Models\NutritionalPlan;
use App\Models\Recipe;
use App\Models\ServicePortion;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExistServicePortion implements ValidationRule
{
    protected $field;

    public function __construct($field = '_id')
    {
        $this->field = $field;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $service_portion = !ServicePortion::where($this->field, $value)->exists();

        if ($attribute == 'service_portion_id' && $service_portion) {
            $fail('Este'. $attribute .'no existe');
        }
    }
}
