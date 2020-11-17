<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        schema::create('product_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('desc')->nullable();
            $table->string('title')->nullable();
            $table->string('bdesc')->nullable();
            $table->string('btitle')->nullable();
        });

        DB::table('product_info')->insert(
            [
                [
                    'desc' => 'Lorem Ipsum',
                    'title' => 'Item Stock',
                    'bdesc' => 'Lorem Ipsum',
                    'btitle' => 'Item Stock',
                ]
            ]
        );
    
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('product_info');
    }
}
