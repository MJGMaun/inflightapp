<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovieCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('movie_category_name');
            $table->string('movie_category_price_ewallet');
            $table->string('movie_category_price_token');
            $table->string('movie_category_description')->nullable();
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
        Schema::dropIfExists('movie_categories');
    }
}
