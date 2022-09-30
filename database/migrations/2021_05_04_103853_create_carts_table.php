<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->uuid('identifier');
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('address_id')->nullable()->constrained()->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->decimal('sub_total')->default(0);
            $table->decimal('shipping_cost')->nullable()->default(0);
            $table->float('discount_percentage')->default(0);
            $table->decimal('discount')->default(0);
            $table->decimal('total')->storedAs('(`sub_total` + CASE WHEN shipping_cost IS NULL THEN 0 ELSE shipping_cost END) - `discount`');
            $table->unsignedInteger('payment_method')->nullable();
            $table->timestamps();
        });

        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->json('color')->nullable();
            $table->json('size')->nullable();
            $table->decimal('price');
            $table->unsignedInteger('quantity');
            $table->boolean('updated')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
