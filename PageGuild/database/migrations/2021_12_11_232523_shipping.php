<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Shipping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping', function (Blueprint $table) {
            $table->id();
            $table->integer('address_id');
            $table->timestamp('expected_date')->nullable();
            $table->integer('shipping_state_id');
            $table->integer('order_id');

            $table->foreign('address_id')->references('id')->on('address');
            $table->foreign('shipping_state_id')->references('id')->on('shipping_state');
            $table->foreign('order_id')->references('id')->on('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shipping');
    }
}
