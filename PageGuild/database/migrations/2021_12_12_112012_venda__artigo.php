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
        Schema::create('Venda_Artigo', function (Blueprint $table) {
            $table->integer('Venda_id');
            $table->integer('Artigo_id');
            $table->integer('quantidade');

            $table->foreign('Venda_id')->references('id')->on('Venda');
            $table->foreign('Artigo_id')->references('id')->on('Artigo');
            
            $table->primary(['Venda_id', 'Artigo_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Venda_Artigo');
    }
}
