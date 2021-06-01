<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductGradeTypiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_grade_typies', function (Blueprint $table) {
            $table->id();
            $table->integer('bussiness_type_id')->nullable();;
            $table->string('name',150)->nullable();
            $table->text('description')->nullable();

            
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
        Schema::dropIfExists('product_grade_typies');
    }
}
