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
        Schema::create('genero_livro', function (Blueprint $table) {
            $table->integer('genero_id');
            $table->integer('livro_artigo_id');

            $table->foreign('genero_id')->references('id')->on('genero');
            $table->foreign('livro_artigo_id')->references('artigo_id')->on('livro');

            $table->primary(['genero_id','livro_artigo_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('genero_livro');
    }
}
