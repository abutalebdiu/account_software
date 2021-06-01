<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleShippingAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_shipping_addresses', function (Blueprint $table) {
            $table->id();

            $table->integer('sale_final_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('business_location_id')->nullable();
            $table->integer('business_type_id')->nullable();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('sale_shipping_addresses');
    }
}
