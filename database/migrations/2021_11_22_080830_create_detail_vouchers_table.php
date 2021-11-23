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
        Schema::create('voucher_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('narration')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedBigInteger('sub_account_id');
            $table->foreign('sub_account_id')->references('id')->on('sub_accounts')->onDelete('cascade');
            $table->string('transaction_type');
            $table->string('entry_type');
            $table->integer('debit_amount')->default(0);
            $table->integer('credit_amount')->default(0);
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
