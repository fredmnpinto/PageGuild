<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Item extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', $precision = 5, $scale = 2);
            $table->timestamp('register_date');
            $table->timestamp('update_date');
            $table->integer('item_type_id');

            $table->foreign('item_type_id')->references('id')->on('item_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('item');
    }
}
