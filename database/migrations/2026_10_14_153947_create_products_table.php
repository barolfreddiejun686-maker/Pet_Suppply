<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('sku')->unique();
            $table->string('pet_type', 30)->nullable(); 
            $table->text('description')->nullable();
            $table->decimal('cost_price', 12, 2)->default(0);
            $table->decimal('price', 12, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->unsignedInteger('reorder_level')->default(5);
            $table->date('expiry_date')->nullable();
            $table->timestamps();

            $table->index('name');
            $table->index('pet_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
