<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaiTable extends Migration
{
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id')->unsigned();
            $table->unsignedBigInteger('seksi_id');
            $table->unsignedBigInteger('jabatan_id');
            $table->string('nama');
            $table->string('nip');
            $table->enum('status_pegawai', ['ASN', 'Non-ASN']);
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seksi_id')->references('id')->on('seksi')->onDelete('cascade');
            $table->foreign('jabatan_id')->references('id')->on('jabatan')->onDelete('cascade');
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
        Schema::dropIfExists('pegawai');
    }
}
