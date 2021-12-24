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
            $table->text('name')->unique();
            $table->decimal('price', $precision = 5, $scale = 2);
            $table->timestamp('registration_date');
            $table->timestamp('update_date')->nullable();
            $table->integer('item_type_id');
            $table->boolean('flag_delete')->nullable(false)->default(false);

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
