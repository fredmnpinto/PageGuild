<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CupomArtigo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Cupom_Artigo', function (Blueprint $table) {
            $table->integer('Cupom_id');
            $table->integer('Artigo_id');

            $table->foreign('Cupom_id')->references('id')->on('Cupom');
            $table->foreign('Artigo_id')->references('id')->on('Artigo');

            $table->primary(['Cupom_id', 'Artigo_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Cupom_Artigo');
    }
}