<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecondaryStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secondary_stocks', function (Blueprint $table) {
            $table->id();

            $table->integer('business_location_id')->nullable();
            $table->integer('business_type_id')->nullable();
            $table->integer('stock_type_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('stock_id')->nullable();
            //$table->integer('branch_id')->nullable();

            /*for product stock*/

            $table->integer('product_variation_id')->nullable();
            $table->integer('product_id')->nullable();

            $table->decimal('available_stock',65,4)->nullable();
            $table->decimal('used_stock',65,4)->nullable();
            //$table->decimal('total_stock_till',500,4)->nullable();

            $table->tinyInteger('stock_lock_applicable')->default(1);
            $table->decimal('stock_lock_quantity',65,4)->nullable();


            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('secondary_stocks');
    }
}
