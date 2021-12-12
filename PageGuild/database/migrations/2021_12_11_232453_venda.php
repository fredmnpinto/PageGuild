<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Venda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Venda', function (Blueprint $table) {
            $table->id();
            $table->timestamp('data_registo');
            $table->integer('Estado_Venda_id');
            $table->integer('Cupom_id')->nullable();

            $table->foreign('Estado_Venda_id')->references('id')->on('Estado_Venda');
            $table->foreign('Cupom_id')->references('id')->on('Cupom');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Venda');
    }
}
