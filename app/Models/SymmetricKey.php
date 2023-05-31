<?php

namespace App\Models;

use App\Constants\Bits;
use App\Constants\SymmetricKeyTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function components(): HasMany
    {
        return $this->hasMany(SymmetricKeyComponent::class);
    }

    public function getKey(): string
    {
        return Crypt::decryptString($this->key);
    }

    public function getCryptogram(): string
    {
        return Crypt::decryptString($this->cryptogram);
    }
}
