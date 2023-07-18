<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('input_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_utama_id');
            $table->unsignedBigInteger('jenis_data_id');
            $table->unsignedBigInteger('kategori_data_id');
            $table->unsignedBigInteger('tahun_data_id');
            $table->string('jumlah_data')->nullable();
            $table->foreign('data_utama_id')->references('id')->on('data_utama')->onDelete('cascade');
            $table->foreign('jenis_data_id')->references('id')->on('jenis_data')->onDelete('cascade');
            $table->foreign('kategori_data_id')->references('id')->on('kategori_data')->onDelete('cascade');
            $table->foreign('tahun_data_id')->references('id')->on('tahun_data')->onDelete('cascade');
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
        Schema::dropIfExists('input_data');
    }
}
