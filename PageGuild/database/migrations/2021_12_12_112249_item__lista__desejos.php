<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ItemListaDesejos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_lista_desejos', function (Blueprint $table) {
            $table->id();
            $table->integer('usuario_id');
            $table->integer('artigo_id');
            $table->boolean('flg_delete');
            $table->timestamp('data_registo');

            $table->foreign('usuario_id')->references('id')->on('usuario');
            $table->foreign('artigo_id')->references('id')->on('artigo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('item_lista_desejos');
    }
}
