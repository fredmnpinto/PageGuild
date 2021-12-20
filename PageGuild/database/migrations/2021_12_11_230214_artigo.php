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
        Schema::create('artigo', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->decimal('preco', $precision = 5, $scale = 2);
            $table->timestamp('data_registo');
            $table->timestamp('data_update');
            $table->integer('tipo_artigo_id');

            $table->foreign('tipo_artigo_id')->references('id')->on('tipo_artigo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('artigo');
    }
}
