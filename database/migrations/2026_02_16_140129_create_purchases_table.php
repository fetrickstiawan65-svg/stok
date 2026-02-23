<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique(); // PUR-YYYYMMDD-0001
            $table->foreignId('supplier_id')->constrained()->restrictOnDelete();
            $table->date('date');

            $table->bigInteger('subtotal')->default(0);
            $table->bigInteger('discount_total')->default(0);
            $table->bigInteger('grand_total')->default(0);

            $table->string('status')->default('RECEIVED'); // RECEIVED / VOID
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
