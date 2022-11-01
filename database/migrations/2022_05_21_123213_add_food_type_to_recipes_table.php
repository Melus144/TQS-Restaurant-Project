<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFoodTypeToRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->integer('food_type')->default(-1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn('food_type');
        });
    }
}
