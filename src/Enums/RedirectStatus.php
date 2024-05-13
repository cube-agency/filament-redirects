<?php

namespace CubeAgency\FilamentRedirects\Enums;

enum RedirectStatus: int
{
    case PERMANENT = 301;
    case TEMPORARY = 302;

    public static function asSelectArray(): array
    {
        $array = [];
        $reflector = new \ReflectionEnum(self::class);

        foreach ($reflector->getCases() as $case) {
            $value = $case->getBackingValue();
            $array[$value] = __('filament-redirects::redirects.status.'.$value);
        }

        return $array;
    }
}
