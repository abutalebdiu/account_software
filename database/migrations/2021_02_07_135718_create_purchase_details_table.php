<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_final_id')->nullable();
            $table->integer('business_location_id')->nullable();
            $table->integer('business_type_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->string('reference_no',150)->nullable();
            $table->string('invoice_no',150)->nullable();
            $table->string('chalan_no',150)->nullable();
            $table->integer('supplier_id')->nullable();

            $table->integer('product_variation_id')->nullable();
            $table->integer('product_id')->nullable();
            
            $table->decimal('quanity',20,2)->nullable();

            $table->decimal('purchase_unit_price_before_discount',20,2)->nullable();
            $table->tinyInteger('discount_type')->default(1);//1=parcent,2=fixed
            $table->decimal('discount_value',20,2)->nullable();
            $table->decimal('discount_amount',20,2)->nullable();

            $table->decimal('purchase_unit_price_before_tax',20,2)->nullable();
            $table->decimal('sub_total_before_tax_amount',20,2)->nullable();
           
            $table->decimal('product_tax',20,2)->nullable();
            $table->decimal('purchase_unit_price_inc_tax',20,2)->nullable();
            $table->decimal('sub_total_inc_tax_amount',20,2)->nullable();

            $table->decimal('default_purchase_price',20,2)->nullable();
            $table->decimal('sub_total_default_purchase_amount',20,2)->nullable();

            $table->decimal('unit_selling_price_inc_tax',20,2)->nullable();
            $table->decimal('unit_selling_price_exc_tax',20,2)->nullable();
            $table->decimal('default_selling_price',20,2)->nullable();

            //----------------------------------------
            $table->integer('default_purchase_unit_id')->nullable();//
            $table->integer('default_regular_sale_unit_id')->nullable();//
            //--------------------
            $table->decimal('profit_margin_parcent',20,2)->nullable();
            $table->decimal('profit_amount',20,2)->nullable();
            //----------------------------------------
            $table->integer('purchase_delivery_status_id')->nullable();//
            //----------------------------------------
            $table->tinyInteger('return_request_status')->nullable();//
            $table->dateTime('return_request_date')->nullable();//
            $table->integer('return_requested_by')->nullable();//
            $table->dateTime('return_accepted_date')->nullable();//
            $table->decimal('return_quantity',20,2)->nullable();

            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_verified')->default(1);
            $table->dateTime('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('purchase_details');
    }
}
