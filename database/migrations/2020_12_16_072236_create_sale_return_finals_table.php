<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleReturnFinalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_return_finals', function (Blueprint $table) {
            $table->id();

            $table->integer('customer_id')->nullable();
            $table->integer('sale_final_id')->nullable();
            $table->string('order_no',30)->nullable();
            $table->string('return_invoice_no',30)->nullable();
         
            $table->decimal('others_cost',20,2)->nullable();
            $table->tinyInteger('discount_type')->default(1);//1=parcent,2=fixed
            $table->decimal('discount_value',20,2)->nullable();
            $table->decimal('discount_amount',20,2)->nullable();

            $table->string('return_date',25)->nullable();
           
            $table->string('status',20)->nullable();
            $table->string('return_note',150)->nullable();
            $table->string('receive_note',150)->nullable();
            $table->string('receive_status',20)->nullable();
            $table->string('return_request_status',20)->nullable();
            
            $table->integer('return_received_by')->nullable(); 
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
        Schema::dropIfExists('sale_return_finals');
    }
}
