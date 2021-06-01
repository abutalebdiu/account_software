<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrunchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brunches', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name');
            $table->string('shopname');
            $table->text('description')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('commission_status')->nullable();
            $table->string('commission_type')->nullable();
            $table->string('commission_rate')->nullable();
            $table->string('status')->default(1);
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
        Schema::dropIfExists('brunches');
    }
}
