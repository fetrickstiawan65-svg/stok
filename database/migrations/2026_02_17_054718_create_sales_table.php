<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique(); // SAL-YYYYMMDD-0001
            $table->date('date');

            $table->bigInteger('subtotal')->default(0);
            $table->bigInteger('discount_total')->default(0);
            $table->bigInteger('tax_amount')->default(0);
            $table->bigInteger('grand_total')->default(0);

            $table->string('payment_method'); // cash/transfer/qris
            $table->bigInteger('paid_amount')->default(0);
            $table->bigInteger('change_amount')->default(0);

            $table->string('status')->default('PAID'); // PAID / VOID
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
