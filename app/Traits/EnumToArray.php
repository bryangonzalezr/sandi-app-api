<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait EnumToArray
{
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }

    public static function get(): array
    {
        return self::collect()->all();
    }

    public static function collect(): Collection
    {
        return collect(self::cases())->map(function ($item) {
            return [
                'value' => $item->value,
                'name' => self::translation()[$item->name] ?? str($item->name)->replace('_', ' ')->toString()
            ];
        });
    }

    /**
     * Sobrescribe este método para traducir los casos del enum
     *
     * @return array<key, value>
     */
    public static function translation(): array
    {
        return [];
    }

    public function getName(): string
    {
        return self::translation()[$this->name] ?? str($this->name)->replace('_', ' ')->toString();
    }

    public static function fromName(string $name): string
    {
        foreach (self::cases() as $status) {
            if (trans($name) === $status->name) {
                return $status->value;
            }
        }
        throw new \ValueError("$name is not a valid backing value for enum " . self::class);
    }

    public  static function tryName(string $name): static|null
    {
        foreach (self::cases() as $status) {
            if (in_array($name, [$status->name, $status->getName()])) {
                return $status;
            }
        }

        return null;
    }

    public static function tryAll(string $value): static|null
    {
        $enum = self::tryFrom($value);

        if (!is_null($enum)) {
            return $enum;
        }

        return self::tryName($value);
    }
}
