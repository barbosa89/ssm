<?php

namespace App\Models;

use App\Constants\Bits;
use App\Constants\SymmetricKeyTypes;
use App\Util\KeyGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class SymmetricKey extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'bits' => Bits::class,
        'type' => SymmetricKeyTypes::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function decryptKey(): string
    {
        return Crypt::decryptString($this->key);
    }

    public function getKCV(): string
    {
        return KeyGenerator::calculateKCV(hex2bin($this->decryptKey()), $this->bits);
    }
}
