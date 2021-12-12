<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditorLivro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Editor_Livro', function (Blueprint $table) {
            $table->integer('Editor_id');
            $table->integer('Livro_Artigo_id');

            $table->foreign('Editor_id')->references('id')->on('Editor');
            $table->foreign('Livro_Artigo_id')->references('Artigo_id')->on('Livro');

            $table->primary('Livro_Artigo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Editor_Livro');
    }
}
