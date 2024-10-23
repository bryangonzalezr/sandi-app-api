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
        $menu = !Menu::where($this->field, $value)->exists();
        $day_menu = !DayMenu::where($this->field, $value)->exists();

        if ($attribute == 'menu_id' && $menu) {
            $fail('Este'. $attribute .'no existe');
        }

        if ($attribute == 'day_menu_id' && $day_menu){
            $fail('Este'. $attribute .'no existe');
        }
    }
}
