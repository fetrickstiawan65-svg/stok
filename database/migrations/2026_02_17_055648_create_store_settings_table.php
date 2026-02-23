<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->string('store_name')->default('Toko Bangunan');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();

            $table->boolean('tax_enabled')->default(false);
            $table->integer('tax_percent')->default(0); // 0..100

            $table->boolean('rounding_enabled')->default(false);
            $table->string('rounding_mode')->default('NONE'); // NONE / UP / DOWN / NEAREST
            $table->integer('rounding_to')->default(100); // contoh 100 rupiah

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_settings');
    }
};
