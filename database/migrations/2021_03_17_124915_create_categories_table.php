<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->cascadeOnDelete();
            $table->json('parents')->nullable();
            $table->boolean('display_in_home')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->string('name')->nullable();
            $table->string('locale')->index();
            $table->unique(['category_id', 'locale']);
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_translations');
        Schema::dropIfExists('categories');
    }
}
