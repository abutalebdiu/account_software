<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountPaymentHistoryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_payment_history_details', function (Blueprint $table) {
            $table->id();
            $table->integer('account_payment_history_id')->nullable();
            $table->string('payment_invoice_no',50)->nullable();
            $table->string('payment_reference_no',100)->nullable();
            $table->tinyInteger('module_id')->nullable();//like, sale, purchase, expense, extra income etc
            
            $table->integer('account_id')->nullable();
            $table->integer('payment_method_id')->nullable();

            $table->string('card_number',150)->nullable();
            $table->string('card_holder_name',255)->nullable();
            $table->string('card_transaction_no',255)->nullable();
            $table->string('card_type',5)->nullable();
            $table->string('expire_month',10)->nullable();
            $table->string('expire_year',5)->nullable();
            $table->string('card_security_code',150)->nullable();
            $table->string('from_mobile_banking_account',20)->nullable();
            $table->string('cheque_no',200)->nullable();
            $table->string('transfer_bank_account_no',200)->nullable();
            $table->string('transaction_no',255)->nullable();
            $table->text('payment_note')->nullable();
            $table->text('description')->nullable();


            $table->integer('created_by')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_verified')->default(1);
            $table->dateTime('deleted_at')->nullable();


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
        Schema::dropIfExists('account_payment_history_details');
    }
}
