<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class SymmetricKeyComponent extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['component', 'kcv'];

    public function getComponent(): string
    {
        return Crypt::decryptString($this->component);
    }
}
