<?php

namespace App\Enums\Param;

enum ParamFilterTypeEnum: int
{
    case INTEGER = 1;
    case SELECT = 2;
    case CHECKBOX = 3;

    public static function names(): array
    {
        return array_map('strtolower', array_column(self::cases(), 'name'));
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function combine(): array
    {
        return array_combine(self::names(), self::values());
    }

    public static function map(): array
    {
        return array_combine(self::values(), self::names());
    }

    public static function collection(): array
    {
        $arr = [];
        foreach (self::map() as $value => $title) {
            $arr[] = [
                'title' => $title,
                'value' => $value
            ];
        }
        return  $arr;
    }

    public static function valuesAsString(): string
    {
        return implode(',', self::values());
    }
}

