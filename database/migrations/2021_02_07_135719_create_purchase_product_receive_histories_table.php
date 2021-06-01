<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseProductReceiveHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_product_receive_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_final_id')->nullable();
            $table->integer('purchase_detail_id')->nullable();
            $table->integer('business_location_id')->nullable();
            $table->integer('business_type_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->string('reference_no',150)->nullable();
            $table->string('invoice_no',150)->nullable();
            $table->string('chalan_no',150)->nullable();
            $table->integer('supplier_id')->nullable();

            $table->integer('product_variation_id')->nullable();
            $table->integer('product_id')->nullable();

            $table->decimal('received_quantity',20,2)->nullable();
            $table->integer('received_by')->nullable();
            $table->dateTime('received_at')->nullable();
            $table->string('received_from',250)->nullable();
            $table->string('received_invo_cln_ref_no',150)->nullable();

            $table->tinyInteger('receiving_period')->default(1); //1=instant ,2=litter

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
        Schema::dropIfExists('purchase_product_receive_histories');
    }
}
