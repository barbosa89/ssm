<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('symmetric_key_components', function (Blueprint $table) {
            $table->id();
            $table->text('component');
            $table->string('kcv');
            $table->foreignId('symmetric_key_id');

            $table->foreign('symmetric_key_id')
                ->references('id')
                ->on('symmetric_keys')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('symmetric_key_components');
    }
};
