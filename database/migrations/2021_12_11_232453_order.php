<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Order extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->timestamp('registration_date');
            $table->timestamp('update_date');
            $table->integer('order_status_id');
            $table->integer('coupon_id')->nullable();
            $table->integer('user_id');

            $table->foreign('order_status_id')->references('id')->on('order_status');
            $table->foreign('coupon_id')->references('id')->on('coupon');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order');
    }
}
