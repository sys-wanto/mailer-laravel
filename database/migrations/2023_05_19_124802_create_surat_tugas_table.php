<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratTugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_tugas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seksi_id');
            $table->unsignedBigInteger('klasifikasi_surat_id');
            $table->date('tanggal_surat_tugas');
            $table->enum('jenis_surat_tugas', ['Dengan SPD', 'Tanpa SPD']);
            $table->string('perihal_surat_tugas');
            $table->enum('sifat_surat_tugas', ['Sangat Segera', 'Segera', 'Biasa']);
            $table->enum('keamanan_surat_tugas', ['Sangat Rahasia', 'Rahasia', 'Biasa']);
            $table->string('tempat_tugas');
            $table->date('tanggal_tugas');
            $table->date('tanggal_selesai_tugas');
            $table->string('file_surat_tugas');
            $table->unsignedBigInteger('perekam_id');
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
        Schema::table('surat_tugas', function (Blueprint $table) {
            $table->dropForeign('perekam_id');
            $table->dropForeign('seksi_id');
            $table->dropForeign('klasifikasi_surat_id');
        });
        Schema::dropIfExists('surat_tugas');
    }
}
