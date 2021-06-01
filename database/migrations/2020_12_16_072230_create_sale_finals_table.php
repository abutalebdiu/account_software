<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleFinalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_finals', function (Blueprint $table) {
            $table->id(); 
            $table->tinyInteger('invoice_status')->nullable();
            $table->integer('customer_id')->nullable();
            $table->string('order_no',30)->nullable();
            $table->decimal('quantity',20,2)->nullable();
           
            $table->decimal('other_cost',20,2)->nullable();
            $table->string('discount_type',20)->nullable();
            $table->decimal('discount_value',20,2)->nullable();
            $table->decimal('discount_amount',20,2)->nullable();
            $table->decimal('final_total',20,2)->nullable();
            
            $table->string('sale_date',25)->nullable();
            
 
           
            $table->string('status',20)->nullable();
            

            $table->string('delivery_note',50)->nullable();
            $table->string('delivery_status',20)->nullable();
            $table->string('return_request_status',20)->nullable();
            $table->decimal('return_quantity',20,2)->nullable();
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
        Schema::dropIfExists('sale_finals');
    }
}
