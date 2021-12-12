<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Promocao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Promocao', function (Blueprint $table) {
            $table->id();
            $table->integer('desconto'); //desconto em %
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->date('data_delete')->nullable();
            $table->boolean('flg_delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Promocao');
    }
}
