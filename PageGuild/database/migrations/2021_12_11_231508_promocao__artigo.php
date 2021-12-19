<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PromotionItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_item', function (Blueprint $table) {
            $table->integer('promotion_id');
            $table->integer('item_id');

            $table->foreign('promotion_id')->references('id')->on('promotion');
            $table->foreign('item_id')->references('id')->on('item');

            $table->primary(['promocao_id', 'artigo_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('promotion_item');
    }
}
