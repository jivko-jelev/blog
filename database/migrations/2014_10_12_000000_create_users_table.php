<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name', 15)->unique();
            $table->string('email')->unique();
            $table->enum('gender', ['Female', 'Male']);
            $table->string('password');
            $table->boolean('admin')->default(0);
            $table->string('avatar')->nullable();
            $table->unsignedTinyInteger('status')->default(0);//0-activated, 255-blocked
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
