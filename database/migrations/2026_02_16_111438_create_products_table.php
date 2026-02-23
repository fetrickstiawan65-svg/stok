<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // contoh: SEMEN-001
            $table->string('name');
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('unit_id')->constrained()->restrictOnDelete();

            $table->bigInteger('cost_price')->default(0);   // harga_beli (IDR)
            $table->bigInteger('sell_price')->default(0);   // harga_jual (IDR)
            $table->integer('stock_minimum')->default(0);

            $table->integer('current_stock')->default(0);   // cache stok
            $table->boolean('is_active')->default(true);

            $table->string('photo_path')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
