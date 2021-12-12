<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GeneroLivro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Genero_Livro', function (Blueprint $table) {
            $table->integer('Genero_id');
            $table->integer('Livro_Artigo_id');

            $table->foreign('Genero_id')->references('id')->on('Genero');
            $table->foreign('Livro_Artigo_id')->references('Artigo_id')->on('Livro');

            $table->primary(['Genero_id','Livro_Artigo_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Genero_Livro');
    }
}
