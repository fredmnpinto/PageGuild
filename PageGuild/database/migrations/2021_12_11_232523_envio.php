<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Envio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('envio', function (Blueprint $table) {
            $table->id();
            $table->integer('endereco_id');
            $table->timestamp('data_prevista')->nullable();
            $table->integer('estado_encomenda_id');
            $table->integer('venda_id');

            $table->foreign('endereco_id')->references('id')->on('endereco');
            $table->foreign('estado_encomenda_id')->references('id')->on('estado_encomenda');
            $table->foreign('venda_id')->references('id')->on('venda');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('envio');
    }
}
