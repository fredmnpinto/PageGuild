<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Book extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book', function (Blueprint $table) {
            $table->integer('item_id');
            $table->string('title', 25);
            $table->string('subtitle', 50)->nullable();
            $table->text('synopsis')->nullable();
            $table->integer('publication_year');
            $table->integer('isbn');
            $table->integer('num_pages')->nullable();
            $table->decimal('width', $precision = 3, $scale = 1)->nullable();
            $table->decimal('length', $precision = 3, $scale = 1)->nullable();
            $table->decimal('height', $precision = 3, $scale = 1)->nullable();
            $table->integer('publisher_id')->nullable();

            $table->unique('isbn');

            $table->foreign('item_id')->references('id')->on('item');
            $table->foreign('publisher_id')->references('id')->on('publisher');

            $table->primary('item_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('book');
    }
}
