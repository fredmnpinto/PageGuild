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
        Schema::create('cupom_artigo', function (Blueprint $table) {
            $table->integer('cupom_id');
            $table->integer('artigo_id');

            $table->foreign('cupom_id')->references('id')->on('cupom');
            $table->foreign('artigo_id')->references('id')->on('artigo');

            $table->primary(['cupom_id', 'artigo_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cupom_artigo');
    }
}
