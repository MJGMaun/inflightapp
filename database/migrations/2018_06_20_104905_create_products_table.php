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
            $table->increments('id');
            $table->integer('product_category_id')->unsigned();
            $table->integer('product_sub_category_id')->unsigned();
            $table->string('product_name');
            $table->string('product_company');
            $table->string('product_price');
            $table->string('product_price_before_discount');
            $table->string('product_description');
            $table->string('product_image_1');
            $table->string('product_image_2');
            $table->string('product_image_3');
            $table->string('product_availability');
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
        Schema::dropIfExists('products');
    }
}
