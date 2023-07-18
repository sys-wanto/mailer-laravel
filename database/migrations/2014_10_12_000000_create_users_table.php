<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username', 15)->unique();
            $table->string('email');
            $table->string('password');
            $table->string('gambar')->nullable();
            $table->enum('level', ['admin_user', 'admin_data', 'admin_arsip', 'kepala_kantor', 'kepala_tu', 'staff_tu', 'kepala_seksi', 'staff_seksi', 'user']);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}