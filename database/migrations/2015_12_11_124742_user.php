<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('username')->unique();
            $table->text('email', 70)->unique();
            $table->text('password');
            $table->boolean('sex');
            $table->dateTime("email_verified_at")->nullable();
            $table->dateTime("update_date")->nullable();
            $table->timestamp('registration_date');
            $table->text('nif')->nullable();
            $table->rememberToken();
            $table->integer('user_type_id');
            $table->text('img_path')->nullable();

            $table->foreign('user_type_id')->references('id')->on('user_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
