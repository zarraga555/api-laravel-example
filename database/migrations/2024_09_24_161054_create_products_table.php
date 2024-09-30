<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->foreignId('unit_id')->nullable()->constrained('units');
            $table->foreignId('brand_id')->nullable()->constrained('brands');
            $table->foreignId('category_id')->nullable()->constrained('categories');
//            $table->foreignId('branch_offices_id')->nullable()->constrained('branch_offices');
            $table->boolean('enable_stock')->default(0);
            $table->decimal('alert_quantity', 22, 2)->default(0);
            $table->string('pathImage')->nullable();
//            $table->foreignId('taxes_id')->nullable()->constrained('taxes_rates');
            //$table->string('tax_type', ['inclusive', 'exclusive']);
            //$table->String('type', ['single', 'variable']);
            $table->float('purchase_price', 20, 2)->nullable();
            $table->float('margin_of_gain', 22, 2)->nullable();
            $table->float('sale_price', 22, 2)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
