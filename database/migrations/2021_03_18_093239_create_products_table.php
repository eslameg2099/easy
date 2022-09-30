<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->decimal('price');
            $table->decimal('offer_price')->nullable();
            $table->boolean('has_discount')->nullable();
            $table->Integer('quantity');
            $table->float('rate')->nullable();
            $table->json('colors')->nullable();
            $table->json('sizes')->nullable();
            $table->timestamps();
            $table->timestamp('locked_at')->nullable();
            $table->softDeletes();
        });
        Schema::create('category_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('products');
    }
}
