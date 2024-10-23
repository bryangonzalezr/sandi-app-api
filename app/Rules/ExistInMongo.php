<?php

namespace App\Rules;

use App\Models\Menu;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExistInMongo implements ValidationRule
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
        if (!Menu::where($this->field, $value)->exists()) {
            $fail('Este menú no existe');
        }
    }
}
