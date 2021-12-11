<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Usuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Usuario', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email');
            $table->string('password');
            $table->boolean('sexo');
            $table->integer('nif')->nullable();
            $table->date('data_registo');

            $table->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Usuario');
    }
}
