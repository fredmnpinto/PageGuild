<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cidade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Cidade', function (Blueprint $table) {
            $table->id();
            $table->string('cidade');
            $table->integer('Pais_id');
            
            $table->foreign('Pais_id')->references('id')->on('Pais');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Cidade');
    }
}