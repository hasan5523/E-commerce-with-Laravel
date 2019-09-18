<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string("billingFirstName");
            $table->string("billingLastName");
            $table->string("billingUserName");
            $table->string("billingEmail");
            $table->string("billingAddressOne");
            $table->string("billingAddressTwo");
            $table->string("billingCountry");
            $table->string("billingState");
            $table->string("billingZip");
            $table->string("shippingFirstName");
            $table->string("shippingLastName");
            $table->string("shippingAddressOne");
            $table->string("shippingAddressTwo");
            $table->string("shippingCountry");
            $table->string("shippingState");
            $table->string("shippingZip");
            $table->timestamps();
            $table->softDeletes();
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
