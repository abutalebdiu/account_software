<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_final_id')->nullable();
            $table->string('order_no',30)->nullable();

            $table->string('customer_name',150)->nullable();
            $table->string('phone',20)->nullable();
            $table->string('quotation_no',100)->nullable();
            $table->string('validate_date',30)->nullable();
            $table->text('quotation_note')->nullable();
            $table->string('quotation_date',25)->nullable();
         
            $table->integer('created_by')->nullable();
            $table->string('verified',25)->nullable();
            $table->string('deleted_at',25)->nullable();
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
        Schema::dropIfExists('quotation_invoices');
    }
}
