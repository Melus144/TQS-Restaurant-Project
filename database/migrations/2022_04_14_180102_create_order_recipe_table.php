<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderRecipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_recipe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('recipe_id')->constrained();
            $table->integer('quantity');
            $table->double('price');
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
        Schema::dropIfExists('order_recipe');
    }
}
