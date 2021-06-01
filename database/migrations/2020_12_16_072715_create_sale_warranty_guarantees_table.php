<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleWarrantyGuaranteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_warranty_guarantees', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_final_id')->nullable();
            $table->integer('sale_detail_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('sale_date',25)->nullable();
            $table->string('warranty_guarantee_type',25)->nullable();
            $table->decimal('quantity',20,2)->nullable();
            $table->text('identity_number')->nullable();
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
        Schema::dropIfExists('sale_warranty_guarantees');
    }
}
