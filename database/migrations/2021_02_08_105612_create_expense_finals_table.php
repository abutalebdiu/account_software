<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseFinalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_finals', function (Blueprint $table) {
            $table->id();

            $table->integer('business_location_id')->nullable();
            $table->integer('business_type_id')->nullable();

            $table->integer('expense_category_id')->nullable();
            $table->string('reference_no',100)->nullable();
            $table->dateTime('expense_date')->nullable();

            $table->decimal('others_cost',20,2)->nullable();
            $table->tinyInteger('discount_type')->default(1);//1=parcent,2=fixed
            $table->decimal('discount_value',20,2)->nullable();
            $table->decimal('discount_amount',20,2)->nullable();

            $table->text('expense_note')->nullable();

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
        Schema::dropIfExists('expense_finals');
    }
}
