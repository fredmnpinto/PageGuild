<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Venda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venda', function (Blueprint $table) {
            $table->id();
            $table->timestamp('data_registo');
            $table->integer('estado_venda_id');
            $table->integer('cupom_id')->nullable();

            $table->foreign('estado_venda_id')->references('id')->on('estado_venda');
            $table->foreign('cupom_id')->references('id')->on('cupom');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('venda');
    }
}
