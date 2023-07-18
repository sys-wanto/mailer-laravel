<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaDinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_dinas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seksi_id');
            $table->unsignedBigInteger('klasifikasi_surat_id');
            $table->date('tanggal_nota_dinas');
            $table->string('tujuan_nota_dinas');
            $table->string('perihal_nota_dinas');
            $table->enum('sifat_nota_dinas', ['Sangat Segera', 'Segera', 'Biasa']);
            $table->enum('keamanan_nota_dinas', ['Sangat Rahasia', 'Rahasia', 'Biasa']);
            $table->string('file_nota_dinas');
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
        Schema::table('nota_dinas', function (Blueprint $table) {
            $table->dropForeign('perekam_id');
            $table->dropForeign('seksi_id');
            $table->dropForeign('klasifikasi_surat_id');
        });
        Schema::dropIfExists('nota_dinas');
    }
}
