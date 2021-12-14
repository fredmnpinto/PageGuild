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
        Schema::create('autor_livro', function (Blueprint $table) {
            $table->integer('autor_id');
            $table->integer('livro_artigo_id');

            $table->foreign('autor_id')->references('id')->on('autor');
            $table->foreign('livro_artigo_id')->references('artigo_id')->on('livro');

            $table->primary(['autor_id','livro_artigo_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('autor_livro');
    }
}
