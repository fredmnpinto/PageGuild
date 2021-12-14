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
        Schema::create('promocao', function (Blueprint $table) {
            $table->id();
            $table->integer('desconto'); //desconto em %
            $table->timestamp('data_inicio');
            $table->timestamp('data_fim');
            $table->timestamp('data_delete')->nullable();
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
        Schema::drop('promocao');
    }
}
