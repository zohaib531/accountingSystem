<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPVTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_p_v', function (Blueprint $table) {
            $table->id();
            $table->integer("product_id");
            $table->string("name");
            $table->string("color");
            $table->string("size");
            $table->integer("qty");
            $table->string("img")->nullable();
            $table->integer("price");
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
        Schema::dropIfExists('product_p_v');
    }
}
