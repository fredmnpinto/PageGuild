<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AuthorBook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author_book', function (Blueprint $table) {
            $table->integer('author_id');
            $table->integer('book_item_id');

            $table->foreign('author_id')->references('id')->on('author');
            $table->foreign('book_item_id')->references('item_id')->on('book');

            $table->primary(['author_id','book_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('author_book');
    }
}
