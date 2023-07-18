<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';
    protected $fillable = [
        'seksi_id',
        'pegawai_id',
        'klasifikasi_surat_id',
        'tanggal_surat_keluar',
        'tujuan_surat_keluar',
        'perihal_surat_keluar',
        'sifat_surat_keluar',
        'keamanan_surat_keluar',
        'file_surat_keluar',
        'perekam_id',
        'created_at'
    ];

    protected $appends = ['jenis_surat'];

    public function getJenisSuratAttribute()
    {
        return 'SuratKeluar';
    }

    public function seksi()
    {
        return $this->belongsTo(Seksi::class, 'seksi_id', 'id');
    }

    public function klasifikasi_surat()
    {
        return $this->belongsTo(KlasifikasiSurat::class, 'klasifikasi_surat_id', 'id');
    }

    public function perekam()
    {
        return $this->belongsTo(Pegawai::class, 'perekam_id', 'id');
    }

}