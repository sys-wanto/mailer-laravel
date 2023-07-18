<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_data_id');
            $table->string('nama_kategori_data', 100)->nullable();
            $table->foreign('jenis_data_id')->references('id')->on('jenis_data')->onDelete('cascade');
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
        Schema::dropIfExists('kategori_data');
    }
}
