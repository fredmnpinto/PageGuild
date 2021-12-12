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
        Schema::create('Envio', function (Blueprint $table) {
            $table->id();
            $table->integer('Endereco_id');
            $table->timestamp('data_prevista')->nullable();
            $table->integer('Estado_Encomenda_id');
            $table->integer('Venda_id');

            $table->foreign('Endereco_id')->references('id')->on('Endereco');
            $table->foreign('Estado_Encomenda_id')->references('id')->on('Estado_Encomenda');
            $table->foreign('Venda_id')->references('id')->on('Venda');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Envio');
    }
}
