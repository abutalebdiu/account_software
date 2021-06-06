<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('loanuid');
            $table->integer('customer_id');
            $table->decimal('amount',20,2);
            $table->integer('loan_by');
            $table->text('loan_reason');
            $table->string('loan_date');
            $table->string('return_date');
            $table->text('note');
            $table->integer('loan_type'); /*1 for given 2 for taken*/
            $table->string('takenby'); 
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
        Schema::dropIfExists('loans');
    }
}
