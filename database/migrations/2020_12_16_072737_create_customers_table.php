<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            //$table->enum('user_type', ['official', 'client','supplier'])->nullable();
            $table->string('password')->nullable();

            $table->string('gender',10)->nullable();
            $table->string('phone',15)->unique()->nullable();
            $table->string('phone_2',15)->unique()->nullable();
            $table->string('phone_3',15)->unique()->nullable();

            $table->string('blood_group',20)->nullable();
            $table->string('religion',20)->nullable();
            $table->string('id_no',30)->unique()->nullable();
            $table->string('company_name',100)->nullable();
            $table->text('address')->nullable();


            $table->string('verified',25)->nullable();
            $table->string('deleted_at',25)->nullable();
            $table->integer('created_by')->nullable();
            $table->rememberToken();

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
        Schema::dropIfExists('customers');
    }
}
