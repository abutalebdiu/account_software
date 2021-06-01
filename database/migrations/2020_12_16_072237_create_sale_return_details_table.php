<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleReturnDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_return_details', function (Blueprint $table) {
            $table->id();

            $table->integer('sale_final_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('sale_return_final_id')->nullable();
            $table->string('order_no',30)->nullable();
            $table->string('return_invoice_no',30)->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('product_variation_id')->nullable();
            //$table->integer('sale_detail_id')->nullable();

            $table->decimal('return_quantity',20,2)->nullable();
            $table->decimal('return_unit_price',20,2)->nullable();
           /*  $table->string('discount_type',20)->nullable();
            $table->decimal('discount_value',20,2)->nullable();
            $table->decimal('discount_amount',20,2)->nullable(); */
            $table->decimal('sub_total',20,2)->nullable();
            $table->string('return_date',25)->nullable();
            //$table->string('description',100)->nullable();
            $table->string('return_status',20)->nullable();

            $table->integer('return_stock_id')->nullable();
            $table->integer('return_unit_id')->nullable();
            $table->integer('return_type_id')->nullable();

            $table->string('return_request_status',20)->nullable();
           
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
        Schema::dropIfExists('sale_return_details');
    }
}
