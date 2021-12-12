<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AutorLivro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Autor_Livro', function (Blueprint $table) {
            $table->integer('Autor_id');
            $table->integer('Livro_Artigo_id');

            $table->foreign('Autor_id')->references('id')->on('Autor');
            $table->foreign('Livro_Artigo_id')->references('Artigo_id')->on('Livro');

            $table->primary(['Autor_id','Livro_Artigo_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Autor_Livro');
    }
}
