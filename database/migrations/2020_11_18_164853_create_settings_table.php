<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            $table->integer('company_uid');
            $table->integer('user_id');
            $table->integer('bussiness_type_id');


            $table->string('shopname');
            $table->text('address');
            $table->string('phone');
            $table->integer('vat_status');
            $table->string('vat_registration');
            $table->string('print_format');
            $table->string('logo');
            $table->string('invoice_logo');
            $table->text('footer_text');
            
            $table->integer('sms_company')->nullable();
            $table->string('sms_api')->nullable();
            $table->string('sms_username')->nullable();
            $table->string('sms_password')->nullable();

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
        Schema::dropIfExists('settings');
    }
}
