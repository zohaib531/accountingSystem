<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_vouchers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('account');
            $table->string('transaction_type');
            $table->integer('debit');
            $table->integer('credit');
            $table->softDeletes();
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
        Schema::dropIfExists('detail_vouchers');
    }
}
