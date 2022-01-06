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
            $table->unsignedBigInteger('sub_account_id');
            $table->date('date');
            $table->string('product_narration')->nullable();
            $table->string('entry_type');
            $table->string('quantity')->default(0);
            $table->string('rate')->default(0);
            $table->string('debit_amount')->default(0);
            $table->string('credit_amount')->default(0);
            $table->string('suspense_account')->default(0);
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
