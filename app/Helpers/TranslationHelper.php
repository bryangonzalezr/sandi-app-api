<?php

namespace App\Helpers;

use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class TranslationHelper
{
    public static function translate(string $text): string
    {
        $translator = new \DeepL\Translator(config('deepl.authToken'));

        $result = $translator->translateText($text, null, 'es');
        return $result;
    }

    public static function translateCollection(Collection $collection): Collection
    {
        return $collection->map(function ($item) {
            return self::translate($item);
        });
    }
}
