<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Payment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->timestamp('register_date');
            $table->timestamp('payment_date')->nullable();
            $table->timestamp('deadline')->nullable();
            $table->integer('payment_status_id');
            $table->integer('order_id');

            $table->foreign('payment_status_id')->references('id')->on('payment_status');
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
        Schema::drop('payment');
    }
}
