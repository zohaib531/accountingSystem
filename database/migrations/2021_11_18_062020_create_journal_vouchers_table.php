<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_vouchers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date');
            $table->string('naration');
            $table->integer('debit_account_id');
            $table->integer('debit_amount');
            $table->string('debit_transaction_type');
            $table->integer('credit_account_id');
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
        Schema::dropIfExists('journal_vouchers');
    }
}
