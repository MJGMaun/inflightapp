<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('cast');
            $table->integer('category_id');
            $table->string('language');
            $table->string('running_time');
            $table->date('release_date');
            $table->string('cover_image');
            $table->string('movie_video');
            $table->string('trailer_video');
            $table->string('ewallet_price');
            $table->string('token_price');
            $table->mediumText('movie_description');
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
        Schema::dropIfExists('movies');
    }
}
