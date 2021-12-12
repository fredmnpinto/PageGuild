<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ItemListaReservas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Item_Lista_Reservas', function (Blueprint $table) {
            $table->id();
            $table->integer('Usuario_id');
            $table->integer('Artigo_id');
            $table->boolean('flg_delete');
            $table->timestamp('data_registo');

            $table->foreign('Usuario_id')->references('id')->on('Usuario');
            $table->foreign('Artigo_id')->references('id')->on('Artigo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Item_Lista_Reservas');
    }
}