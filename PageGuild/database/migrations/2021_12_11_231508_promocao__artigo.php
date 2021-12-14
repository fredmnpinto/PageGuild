<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PromocaoArtigo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promocao_artigo', function (Blueprint $table) {
            $table->integer('promocao_id');
            $table->integer('artigo_id');

            $table->foreign('promocao_id')->references('id')->on('promocao');
            $table->foreign('artigo_id')->references('id')->on('artigo');

            $table->primary(['promocao_id', 'artigo_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('promocao_artigo');
    }
}
