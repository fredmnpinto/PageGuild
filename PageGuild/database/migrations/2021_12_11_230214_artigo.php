<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Artigo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Artigo', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->decimal('preco', $precision = 5, $scale = 2);
            $table->date('data_registo');
            $table->date('data_update');
            $table->integer('Tipo_Artigo_id');

            $table->foreign('Tipo_Artigo_id')->references('id')->on('Tipo_Artigo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Artigo');
    }
}
