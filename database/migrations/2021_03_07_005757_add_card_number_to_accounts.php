<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCardNumberToAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('card_no')->nullable();
            $table->string('card_holder')->nullable();
            $table->string('transection_no')->nullable();
            $table->string('card_type')->nullable();
            $table->string('card_expire_date')->nullable();
            $table->string('security_code')->nullable();
        });
    }
}
