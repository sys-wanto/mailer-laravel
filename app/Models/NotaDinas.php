<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaDinas extends Model
{
    use HasFactory;

    protected $table = 'nota_dinas';
    protected $fillable = [
        'seksi_id',
        'pegawai_id',
        'klasifikasi_surat_id',
        'tanggal_nota_dinas',
        'tujuan_nota_dinas',
        'perihal_nota_dinas',
        'sifat_nota_dinas',
        'keamanan_nota_dinas',
        'file_nota_dinas',
        'perekam_id',
        'created_at'
    ];

    protected $appends = ['jenis_surat'];

    public function getJenisSuratAttribute()
    {
        return 'NotaDinas';
    }
    public function seksi()
    {
        return $this->belongsTo(Seksi::class, 'seksi_id', 'id');
    }

    public function klasifikasi_surat()
    {
        return $this->belongsTo(KlasifikasiSurat::class, 'klasifikasi_surat_id', 'id');
    }
}