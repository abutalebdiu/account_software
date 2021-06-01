<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            /* ======== for company details =============  */

            $table->integer('company_uid');
            $table->integer('user_id');
            $table->integer('bussiness_type_id');
            $table->integer('brunch_id');

            $table->integer('supplier_id');

            $table->string('name');
            $table->string('product_uid');
            $table->string('product_sku')->nullable();



            /*= ==== for inventroy  ============*/

            $table->string('purchase_price');
            $table->string('whole_sale_price');
            $table->string('retail_price');
            $table->string('mrp_price');


            /* ===============for online ==========*/

            $table->string('online_sell_price')->nullable();
            $table->string('online_discount_price')->nullable();


            /*==================for category ===================*/

            $table->integer('category_id');
            $table->integer('brand_id')->nullable();
            $table->integer('purchase_unit');
            $table->integer('sale_unit');

            $table->integer('low_sale_qty');
            $table->integer('low_alert_qty');


            /* ========= for common =============*/

            $table->string('default_photo')->nullable();
            $table->string('warranty')->nullable();
            $table->string('guarantee')->nullable();
            $table->text('description')->nullable();


            $table->integer('is_return')->nullable();
            $table->integer('tax_type')->nullable();
            $table->integer('tax')->nullable();
            $table->integer('barcode_type')->nullable();
            $table->integer('initial_stock')->default(1);



            $table->integer('deleted_at')->default(0);
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('products');
    }
}
