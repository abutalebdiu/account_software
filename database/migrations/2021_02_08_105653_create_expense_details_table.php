<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_details', function (Blueprint $table) {
            $table->id();

            $table->integer('business_location_id')->nullable();
            $table->integer('business_type_id')->nullable();

            $table->integer('expense_category_id')->nullable();
            $table->integer('final_expense_id')->nullable();
            $table->string('reference_no',100)->nullable();
            $table->dateTime('expense_created_date')->nullable();

            $table->decimal('sub_total',20,2)->nullable();
            $table->text('expense_title')->nullable();
            $table->text('description')->nullable();

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
        Schema::dropIfExists('expense_details');
    }
}
