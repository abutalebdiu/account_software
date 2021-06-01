<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTransferHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transfer_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('business_location_id')->nullable();
            $table->integer('business_type_id')->nullable();

            $table->integer('from_stock_type_id')->nullable();
            $table->integer('to_stock_type_id')->nullable();
            $table->integer('from_stock_id')->nullable();
            $table->integer('to_stock_id')->nullable();
            $table->integer('from_product_variation_id')->nullable();
            $table->integer('from_product_id')->nullable();
            $table->integer('to_product_variation_id')->nullable();
            $table->integer('to_product_id')->nullable();
            $table->integer('transfer_quantity')->default(0);
            $table->integer('receive_quantity')->default(0);
            $table->integer('transfer_by')->nullable();
            $table->integer('receive_by')->nullable();
            $table->dateTime('receive_at')->nullable();

            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_verified')->default(1);

            $table->integer('created_by')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('stock_transfer_histories');
    }
}
