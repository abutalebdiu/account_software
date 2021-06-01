<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();

            $table->integer('business_location_id')->nullable();
            $table->integer('business_type_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('payment_method_id')->nullable();
            $table->integer('bank_id')->nullable();

            $table->string('account_name',250)->nullable();
            $table->string('account_no',150)->nullable();
            $table->decimal('opening_amount',20,2)->nullable();
            
            $table->string('contract_person',150)->nullable();
            $table->string('contract_phone',20)->nullable();
            $table->text('address')->nullable();

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
        Schema::dropIfExists('accounts');
    }
}
