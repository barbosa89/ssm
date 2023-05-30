<?php

namespace App\Constants;

use App\Concerns\EnumToArray;

enum Bits: int
{
    use EnumToArray;

    case Short = 64;
    case Medium = 128;
    case Big = 196;
    case Long = 256;

    public function bytes(): int
    {
        return $this->value / 8;
    }
}
