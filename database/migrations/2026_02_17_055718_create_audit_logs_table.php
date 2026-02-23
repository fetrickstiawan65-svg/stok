<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action');     // CREATE_SALE, VOID_SALE, CREATE_PURCHASE, VOID_PURCHASE, STOCK_OPENING, dll
            $table->string('entity');     // sales, purchases, products, stock_movements, etc
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->json('meta_json')->nullable();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->timestamps();

            $table->index(['entity','entity_id']);
            $table->index(['action']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
