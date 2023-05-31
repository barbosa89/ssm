<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('symmetric_keys', function (Blueprint $table) {
            $table->string('kcv', 6)->nullable();
            $table->text('cryptogram')->nullable();
            $table->string('transport_key_kcv', 6)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('symmetric_keys', function (Blueprint $table) {
            $table->dropColumn('kcv');
            $table->dropColumn('cryptogram');
            $table->dropColumn('transport_key_kcv');
        });
    }
};
