<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pagamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Pagamento', function (Blueprint $table) {
            $table->id();
            $table->date('data_registo');
            $table->date('data_finalizado')->nullable();
            $table->date('data_limite')->nullable();
            $table->integer('Estado_Pagamento_id');
            $table->integer('Venda_id');

            $table->foreign('Estado_Pagamento_id')->references('id')->on('Estado_Pagamento');
            $table->foreign('Venda_id')->references('id')->on('Venda');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Pagamento');
    }
}
