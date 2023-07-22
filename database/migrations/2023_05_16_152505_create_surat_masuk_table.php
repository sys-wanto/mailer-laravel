<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('asal_surat_masuk');
            $table->string('nomor_surat_masuk');
            $table->date('tanggal_surat_masuk');
            $table->string('lampiran_surat_masuk');
            $table->string('perihal_surat_masuk');
            $table->enum('sifat_surat_masuk', ['Sangat Segera', 'Segera', 'Biasa']);
            $table->enum('keamanan_surat_masuk', ['Rahasia', 'Biasa']);
            $table->string('file_surat_masuk');
            $table->foreignId('rak_penyimpanan_id')->unsigned();
            $table->foreignId('perekam_id')->unsigned();
            $table->foreign('rak_penyimpanan_id')->references('id')->on('klasifikasi_surat')->onDelete('cascade');
            $table->foreign('perekam_id')->references('id')->on('pegawai')->onDelete('cascade');
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
        Schema::dropIfExists('surat_masuk');
    }
}
