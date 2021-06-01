<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseFinalAdditionalNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_final_additional_notes', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_final_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->integer('business_location_id')->nullable();
            $table->integer('business_type_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->text('additional_note')->nullable();
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
        Schema::dropIfExists('purchase_final_additional_notes');
    }
}
