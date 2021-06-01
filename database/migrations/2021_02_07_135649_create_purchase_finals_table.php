<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseFinalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_finals', function (Blueprint $table) {
            $table->id();
            $table->integer('business_location_id')->nullable();
            $table->integer('business_type_id')->nullable();
            $table->integer('branch_id')->nullable();

            $table->string('reference_no',150)->nullable();
            $table->string('invoice_no',150)->nullable();
            $table->string('chalan_no',150)->nullable();

            $table->integer('supplier_id')->nullable();
            
            $table->decimal('others_cost',20,2)->nullable();
            $table->tinyInteger('discount_type')->default(1);//1=parcent,2=fixed
            $table->decimal('discount_value',20,2)->nullable();
            $table->decimal('discount_amount',20,2)->nullable();

            $table->tinyInteger('purchase_tax_applicable')->default(1);
            $table->decimal('purchase_tax_in_parcent_value',20,2)->nullable();
            $table->decimal('purchase_tax_amount',20,2)->nullable();

            $table->decimal('additional_shipping_charge',20,2)->nullable();

            $table->dateTime('purchae_date')->nullable();
            $table->string('file',6)->nullable();

            $table->tinyInteger('purchase_status_id')->default(1);

            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_verified')->default(1);
           
            $table->dateTime('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('purchase_created_by')->nullable();
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
        Schema::dropIfExists('purchase_finals');
    }
}
