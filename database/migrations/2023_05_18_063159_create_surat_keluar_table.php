<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratKeluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seksi_id');
            $table->unsignedBigInteger('klasifikasi_surat_id');
            $table->date('tanggal_surat_keluar');
            $table->string('tujuan_surat_keluar');
            $table->string('perihal_surat_keluar');
            $table->enum('sifat_surat_keluar', ['Sangat Segera', 'Segera', 'Biasa']);
            $table->enum('keamanan_surat_keluar', ['Sangat Rahasia', 'Rahasia', 'Biasa']);
            $table->string('file_surat_keluar');
            $table->foreignId('perekam_id')->unsigned();
            $table->string('nomor_surat')->default('-');
            $table->foreign('seksi_id')->references('id')->on('seksi')->onDelete('cascade');
            $table->foreign('klasifikasi_surat_id')->references('id')->on('klasifikasi_surat')->onDelete('cascade');
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
        Schema::table('surat_keluar', function (Blueprint $table) {
            $table->dropForeign('perekam_id');
            $table->dropForeign('seksi_id');
            $table->dropForeign('klasifikasi_surat_id');
        });
        Schema::dropIfExists('surat_keluar');
    }
}