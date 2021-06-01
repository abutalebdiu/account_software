<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->integer('business_type_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('sub_sku',150)->nullable();
            $table->integer('size_id')->nullable();
            $table->integer('color_id')->nullable();
            $table->integer('weight_id')->nullable();

            $table->decimal('expiry_period',4,2)->nullable();
            $table->enum('expiry_period_type', ['days', 'months','years'])->nullable();

            $table->integer('supplier_id')->nullable();//vandor id
            //----------------------------------------
            $table->tinyInteger('applicable_for_offer_promo_code')->nullable();
            $table->dateTime('promo_code_start_time')->nullable();
            $table->dateTime('promo_code_end_time')->nullable();
            $table->decimal('offer_promo_code_less_amount',20,2)->nullable();
            $table->string('offer_promo_code',100)->nullable();
            //----------------------------------------

            //----------------------------------------
            $table->decimal('online_sale_price',20,2)->nullable();
            $table->decimal('online_mrp_price',20,2)->nullable();
            $table->decimal('retail_price',20,2)->nullable();
            $table->decimal('whole_sale_price',20,2)->nullable();
            $table->decimal('reseller_price',20,2)->nullable();
            $table->decimal('vip_price',20,2)->nullable();
            $table->decimal('mrp_price',20,2)->nullable();
            $table->decimal('group_sale_price',20,2)->nullable();
            //----------------------------------------
            $table->decimal('purchase_unit_price_before_discount',20,2)->nullable();
            $table->decimal('purchase_unit_price_before_tax',20,2)->nullable();
            $table->decimal('purchase_unit_price_inc_tax',20,2)->nullable();
            $table->decimal('default_purchase_price',20,2)->nullable();
            $table->decimal('unit_selling_price_inc_tax',20,2)->nullable();
            $table->decimal('unit_selling_price_exc_tax',20,2)->nullable();
            $table->decimal('default_selling_price',20,2)->nullable();
            //----------------------------------------
            $table->integer('default_purchase_unit_id')->nullable();//
            $table->integer('default_regular_sale_unit_id')->nullable();//
            //--------------------
            $table->decimal('profit_margin_parcent',20,2)->nullable();
            $table->decimal('profit_amount',20,2)->nullable();
            //--------------------
            $table->integer('warrantity_id')->nullable();//
            $table->integer('grarantee_id')->nullable();//
            //--------------------
            $table->decimal('alert_quantity',20,2)->nullable();
            $table->decimal('low_sale_quantity',20,2)->nullable();
            //--------------------
            $table->tinyInteger('applicable_for_returnable')->nullable();
            $table->tinyInteger('sale_tax_type')->nullable();
            $table->decimal('sale_tax_amount',20,2)->nullable();
            $table->tinyInteger('applicable_tax_for_purchase')->nullable();
            $table->tinyInteger('purchase_tax_type')->nullable();
            $table->decimal('purchase_tax_amount',20,2)->nullable();
            $table->tinyInteger('imei_srl_num_enable_disable_type')->nullable();
            $table->tinyInteger('applicable_sale_type')->nullable();
            $table->decimal('sd',20,2)->nullable();
            //--------------------


            $table->decimal('initial_stock',4,2)->nullable();
            //--------------------
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('is_active')->nullable();
            $table->tinyInteger('is_verified')->nullable();
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
        Schema::dropIfExists('product_variations');
    }
}
