<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountPaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->string('payment_invoice_no',50)->nullable();
            $table->string('payment_reference_no',100)->nullable();
            $table->tinyInteger('module_id')->nullable();//like, sale, purchase, expense, extra income etc
            $table->string('module_invoice_no',30)->nullable(); // like invoice_no , order_no
            $table->integer('module_invoice_id')->nullable(); // like sale_final_id,purchase_final_id etc
            $table->integer('account_id')->nullable();
            $table->integer('payment_method_id')->nullable();
            $table->tinyInteger('cdf_type_id')->nullable();  //cdf = credit debit formula
            $table->tinyInteger('payment_type_id')->nullable();  //like income ,expense
            $table->decimal('payment_amount',20,2)->nullable();
            $table->integer('client_supplier_id')->nullable();
            $table->integer('payment_by')->nullable();
            
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
        Schema::dropIfExists('account_payment_histories');
    }
}
