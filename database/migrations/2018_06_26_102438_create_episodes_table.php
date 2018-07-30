<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            // $table->mediumText('description');
            // $table->time('running_time');
            $table->integer('episode_number');
            $table->string('episode_video');
            $table->string('episode_cover_image_id');
            $table->integer('series_id')->unsigned();
            $table->integer('season_id')->unsigned();
            $table->string('ewallet_price');
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
        Schema::dropIfExists('episodes');
    }
}
