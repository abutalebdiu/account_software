<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id(); 
            $table->string('name',150);
            $table->string('phone',15)->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('contract_person',150)->nullable();
            $table->decimal('previous_due', 20, 2)->default(00.00);
            $table->text('address')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
}
