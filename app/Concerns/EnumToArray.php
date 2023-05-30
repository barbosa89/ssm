<?php

namespace App\Concerns;

use App\Constants\Props;

trait EnumToArray
{
    public static function toArray(Props $prop = Props::Value): array
    {
        return array_column(self::cases(), $prop->value);
    }
}
