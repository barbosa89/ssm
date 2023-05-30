<?php

namespace App\Util;

class Binary
{
    public static function toHex(string $binary): string
    {
        return strtoupper(bin2hex($binary));
    }
}
