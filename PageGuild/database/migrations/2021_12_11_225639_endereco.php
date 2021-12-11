<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Endereco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Endereco', function (Blueprint $table) {
            $table->id();
            $table->integer('Cidade_id');
            $table->string('morada');
            $table->integer('Usuario_id');
            $table->boolean('flg_ativo');
            $table->boolean('flg_delete');

            $table->foreign('Cidade_id')->references('id')->on('Cidade');
            $table->foreign('Usuario_id')->references('id')->on('Usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Endereco');
    }
}
