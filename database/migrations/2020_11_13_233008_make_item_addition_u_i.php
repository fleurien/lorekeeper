<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeItemAdditionUI extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('shop_products', function (Blueprint $table) {
            $table->increments('id');
            $table->double('price', 2);
            $table->string('item_id');
            $table->string('quantity');
            $table->boolean('is_bundle')->default(0);
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('shop_products');
    }
}
