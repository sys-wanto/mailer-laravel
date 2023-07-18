<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_utama_id');
            $table->string('nama_jenis_data')->nullable();
            $table->foreign('data_utama_id')->references('id')->on('data_utama')->onDelete('cascade');
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
        Schema::dropIfExists('jenis_data');
    }
}
