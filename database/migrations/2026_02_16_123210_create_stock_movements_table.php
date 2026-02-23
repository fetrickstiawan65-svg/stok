<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();

            $table->string('type'); // OPENING, IN, OUT, ADJUST
            $table->string('ref_type')->nullable(); // PURCHASE, SALE, MANUAL, OPNAME
            $table->unsignedBigInteger('ref_id')->nullable();

            $table->integer('qty_in')->default(0);
            $table->integer('qty_out')->default(0);

            $table->integer('balance_after')->default(0);
            $table->string('notes')->nullable();

            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();

            $table->index(['product_id','created_at']);
            $table->index(['ref_type','ref_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
