<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name',200)->nullable();
            $table->string('location_id',100)->nullable();
            $table->integer('branch_id')->nullable();
            $table->text('landmark')->nullable();
            $table->string('city',150)->nullable();
            $table->string('zip_code',100)->nullable();
            $table->string('state',250)->nullable();
            $table->string('country',200)->nullable();
            $table->string('phone',15)->nullable();
            $table->string('alt_contract_number',15)->nullable();
            $table->string('email',255)->nullable();
            $table->string('website',255)->nullable();

            $table->integer('invoice_scheme')->nullable();
            $table->integer('invoice_layout_for_pos')->nullable();
            $table->integer('invoice_layout_for_sale')->nullable();
            $table->integer('default_selling_price_group')->nullable();
            $table->string('custom_field_1',255)->nullable();
            $table->string('custom_field_2',255)->nullable();
            $table->string('custom_field_3',255)->nullable();

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
        Schema::dropIfExists('business_locations');
    }
}
