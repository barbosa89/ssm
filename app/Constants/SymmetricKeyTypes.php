<?php

namespace App\Constants;

use App\Concerns\EnumToArray;

enum SymmetricKeyTypes
{
    use EnumToArray;

    case RC4;
    case Salsa20;
    case ChaCha20;
    case AES;
    case Rijndael;
    case DES;
    case TripleDES;
    case RC2;
    case Blowfish;
    case Twofish;
}
