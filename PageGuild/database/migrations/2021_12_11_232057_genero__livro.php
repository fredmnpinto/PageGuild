<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GenreBook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genre_book', function (Blueprint $table) {
            $table->integer('genre_id');
            $table->integer('book_item_id');

            $table->foreign('genre_id')->references('id')->on('genre');
            $table->foreign('book_item_id')->references('item_id')->on('book');

            $table->primary(['genre_id','book_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('genre_book');
    }
}
