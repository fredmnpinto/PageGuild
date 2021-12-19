<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pagamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagamento', function (Blueprint $table) {
            $table->id();
            $table->timestamp('data_registo');
            $table->timestamp('data_finalizado')->nullable();
            $table->timestamp('data_limite')->nullable();
            $table->integer('estado_pagamento_id');
            $table->integer('venda_id');

            $table->foreign('estado_pagamento_id')->references('id')->on('estado_pagamento');
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
        Schema::drop('pagamento');
    }
}
