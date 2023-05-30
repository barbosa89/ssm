<?php

namespace App\Util;

use App\Constants\Bits;
use Illuminate\Support\Facades\Crypt;
use phpseclib3\Crypt\TripleDES;

class KeyGenerator
{
    private string $key;

    public function __construct(private Bits $bits)
    {
        $this->key = random_bytes($bits->bytes());
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function toHex(): string
    {
        return Binary::toHex($this->key);
    }

    public function toBase64(): string
    {
        return Crypt::encryptString($this->toHex());
    }

    public static function make(Bits $bits): self
    {
        return new self($bits);
    }

    public static function combination(Bits $bits): array
    {
        [$componentA, $componentB, $componentC] = self::components($bits);

        $key = $componentA ^ $componentB ^ $componentC;

        return [
            'key' => $key,
            'components' => array_map(function (string $component) use ($bits): array {
                return [
                    'component' => Binary::toHex($component),
                    'kcv' => self::calculateKCV($component, $bits),
                ];
            }, [$componentA, $componentB, $componentC]),
        ];
    }

    public static function components(Bits $bits): array
    {
        return [
            self::make($bits)->getKey(),
            self::make($bits)->getKey(),
            self::make($bits)->getKey(),
        ];
    }

    public static function calculateKCV(string $key, Bits $bits): string
    {
        $data = hex2bin(str_pad('0', $bits->bytes(), '0'));

        $cipher = new TripleDES('ECB');
        $cipher->setKey($key);

        $encrypted = $cipher->encrypt($data);

        return strtoupper(substr(bin2hex($encrypted), 0, 6));
    }
}
