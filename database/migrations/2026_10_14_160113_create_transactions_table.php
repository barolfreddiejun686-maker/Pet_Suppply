<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique();
            $table->string('type', 20);                 // stock_in (restock) | stock_out (sale)
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('total', 12, 2)->default(0);
            $table->timestamp('transacted_at')->useCurrent();
            $table->timestamps();

            $table->index('type');
            $table->index('transacted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
