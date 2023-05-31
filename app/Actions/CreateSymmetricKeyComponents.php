<?php

namespace App\Actions;

use App\Constants\Bits;
use App\Models\SymmetricKey;
use App\Models\SymmetricKeyComponent;
use App\Util\Binary;
use App\Util\KeyGenerator;
use Illuminate\Support\Facades\Crypt;
use phpseclib3\Crypt\TripleDES;

class CreateSymmetricKeyComponents
{
    public static function execute(SymmetricKey $symmetricKey): void
    {
        ['key' => $transportKey, 'components' => $components] = KeyGenerator::combination(Bits::Medium);

        $cipher = new TripleDES('ECB');
        $cipher->setKey($transportKey);

        $secret = hex2bin($symmetricKey->getKey());

        $symmetricKey->cryptogram = Crypt::encryptString(Binary::toHex($cipher->encrypt($secret)));
        $symmetricKey->kcv = KeyGenerator::calculateKCV($secret, Bits::Medium);
        $symmetricKey->transport_key_kcv = KeyGenerator::calculateKCV($transportKey, Bits::Medium);
        $symmetricKey->save();

        $components = collect($components)
            ->map(function (array $component) {
                return new SymmetricKeyComponent([
                    'component' => Crypt::encryptString($component['component']),
                    'kcv' => $component['kcv'],
                ]);
            });

        $symmetricKey->components()->saveMany($components);
    }
}
