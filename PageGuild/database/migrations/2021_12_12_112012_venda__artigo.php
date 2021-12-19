<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VendaArtigo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venda_artigo', function (Blueprint $table) {
            $table->integer('venda_id');
            $table->integer('artigo_id');
            $table->integer('quantidade');

            $table->foreign('venda_id')->references('id')->on('venda');
            $table->foreign('artigo_id')->references('id')->on('artigo');
            
            $table->primary(['venda_id', 'artigo_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('venda_artigo');
    }
}
