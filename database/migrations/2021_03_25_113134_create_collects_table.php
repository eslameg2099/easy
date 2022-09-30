<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount');
            $table->timestamp('date');
            $table->timestamps();
        });
        Schema::create('delegate_collects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delegate_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('amount');
            $table->timestamp('date');
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
        Schema::dropIfExists('delegate_collects');
        Schema::dropIfExists('collects');
    }
}
