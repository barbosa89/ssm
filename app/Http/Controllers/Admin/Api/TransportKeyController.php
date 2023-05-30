<?php

namespace App\Http\Controllers\Admin\Api;

use App\Constants\Bits;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Api\GenerateTransportKeyRequest;
use App\Util\Binary;
use App\Util\KeyGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;
use phpseclib3\Crypt\TripleDES;

class TransportKeyController extends Controller
{
    public function generate(GenerateTransportKeyRequest $request): JsonResponse
    {
        $bits = Bits::tryFrom($request->integer('bits'));

        ['key' => $key, 'components' => $components] = KeyGenerator::combination($bits);

        $cipher = new TripleDES('ECB');
        $cipher->setKey($key);

        $secret = hex2bin(Crypt::decryptString($request->string('key')->toString()));

        $cryptogram = $cipher->encrypt($secret);

        return response()->json([
            'cryptogram' => Binary::toHex($cryptogram),
            'kcv' => KeyGenerator::calculateKCV($key, $bits),
            'components' => $components,
        ]);
    }
}
