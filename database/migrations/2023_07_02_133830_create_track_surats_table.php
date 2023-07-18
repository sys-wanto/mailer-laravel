<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackSuratsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('track_surats', function (Blueprint $table) {
            $table->id();
            $table->integer('urutan');
            $table->string('type_surat');
            $table->unsignedBigInteger('id_surat');
            $table->string('posisi_surat');
            $table->date('tgl_terima')->default(null);
            $table->date('tgl_kirim')->default(null);
            $table->unsignedBigInteger('id_pengirim')->nullable();
            $table->unsignedBigInteger('id_penerima')->nullable();
            $table->foreign('id_pengirim')->references('id')->on('pegawai')->onDelete('cascade');
            $table->foreign('id_penerima')->references('id')->on('pegawai')->onDelete('cascade');
            $table->string('catatan');
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
        Schema::table('track_surats', function (Blueprint $table) {
            $table->dropForeign('id_pengirim');
            $table->dropForeign('id_penerima');
        });
        Schema::dropIfExists('track_surats');
    }
}
