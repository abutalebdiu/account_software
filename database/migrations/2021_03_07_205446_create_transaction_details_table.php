<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->integer('business_location_id')->nullable();
            $table->integer('business_type_id')->nullable();

            $table->integer('transaction_type_id')->nullable();
            $table->integer('transaction_category_id')->nullable();
            $table->integer('transaction_final_id')->nullable();
            $table->string('reference_no', 100)->nullable();
            $table->dateTime('transaction_created_date')->nullable();

            $table->text('transaction_title')->nullable();
            $table->text('description')->nullable();
            $table->decimal('sub_total', 20, 2)->nullable();

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
        Schema::dropIfExists('transaction_details');
    }
}
