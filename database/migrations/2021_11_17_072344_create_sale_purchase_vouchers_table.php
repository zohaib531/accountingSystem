<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalePurchaseVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_purchase_vouchers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('debit_account');
            $table->integer('debit_quantity');
            $table->integer('debit_rate');
            $table->integer('debit_amount');
            $table->string('debit_transaction_type');
            $table->string('credit_account');
            $table->integer('credit_quantity');
            $table->integer('credit_rate');
            $table->integer('credit_amount');
            $table->string('credit_transaction_type');
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
        Schema::dropIfExists('sale_purchase_vouchers');
    }
}
