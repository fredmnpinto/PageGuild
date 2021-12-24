<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CouponItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_item', function (Blueprint $table) {
            $table->integer('coupon_id');
            $table->integer('item_id');

            $table->foreign('coupon_id')->references('id')->on('coupon');
            $table->foreign('item_id')->references('id')->on('item');

            $table->primary(['coupon_id', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coupon_item');
    }
}
