<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlasifikasiSurat extends Model
{
    use HasFactory;

    protected $table = 'klasifikasi_surat';
    protected $fillable = ['kode_klasifikasi', 'nama_klasifikasi', 'uraian'];

    public function surat_keluar()
    {
        return $this->hasMany(SuratKeluar::class, 'surat_keluar_id');
    }

    public function surat_tugas()
    {
        return $this->hasMany(SuratTugas::class, 'surat_tugas_id');
    }

    public function surat_masuk()
    {
        return $this->hasMany(SuratMasuk::class, 'surat_masuk_id');
    }
}
