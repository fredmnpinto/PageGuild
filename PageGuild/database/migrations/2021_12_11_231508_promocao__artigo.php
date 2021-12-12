<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PromocaoArtigo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Promocao_Artigo', function (Blueprint $table) {
            $table->integer('Promocao_id');
            $table->integer('Artigo_id');

            $table->foreign('Promocao_id')->references('id')->on('Promocao');
            $table->foreign('Artigo_id')->references('id')->on('Artigo');

            $table->primary(['Promocao_id', 'Artigo_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Promocao_Artigo');
    }
}
