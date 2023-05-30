<?php

use App\Constants\Bits;
use App\Constants\Props;
use App\Constants\SymmetricKeyTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('symmetric_keys', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->enum('type', SymmetricKeyTypes::toArray(Props::Name));
            $table->unsignedSmallInteger('bits')->default(Bits::Medium->value);
            $table->text('key');
            $table->foreignId('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('symmetric_keys');
    }
};
