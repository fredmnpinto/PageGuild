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
            $table->text('title')->unique();
            $table->text('subtitle')->nullable();
            $table->text('synopsis')->nullable();
            $table->integer('publication_year');
            $table->text('isbn')->unique();
            $table->integer('num_pages');
            $table->decimal('width')->nullable();
            $table->decimal('length')->nullable();
            $table->decimal('height')->nullable();
            $table->text('bookbinding')->nullable();
            $table->integer('publisher_id')->nullable();
            $table->integer('language_id');
            $table->integer('edition_year');

            $table->foreign('language_id')->references('id')->on('language');
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
