<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cupom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Cupom', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50);
            $table->timestamp('data_inicio');
            $table->timestamp('data_fim');
            $table->integer('desconto'); //desconto em %
            $table->boolean('flg_ativo');
            $table->string('descricao',255)->nullable();

            $table->unique('codigo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Cupom');
    }
}
