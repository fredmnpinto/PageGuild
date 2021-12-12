<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Livro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Livro', function (Blueprint $table) {
            $table->integer('Artigo_id');
            $table->string('titulo', 25);
            $table->string('subtitulo', 50)->nullable();
            $table->text('sinopse')->nullable();
            $table->integer('ano_publicacao');
            $table->integer('isbn');
            $table->integer('num_paginas')->nullable();
            $table->decimal('largura', $precision = 3, $scale = 1)->nullable();
            $table->decimal('comprimento', $precision = 3, $scale = 1)->nullable();
            $table->decimal('altura', $precision = 3, $scale = 1)->nullable();
            $table->integer('Editor_id')->nullable();

            $table->unique('isbn');

            $table->foreign('Artigo_id')->references('id')->on('Artigo');
            $table->foreign('Editor_id')->references('id')->on('Editor');

            $table->primary('Artigo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Livro');
    }
}
