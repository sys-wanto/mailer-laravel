<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTugas extends Model
{
    use HasFactory;

    protected $table = 'surat_tugas';
    protected $fillable = [
        'seksi_id',
        'pegawai_id',
        'klasifikasi_surat_id',
        'tanggal_surat_tugas',
        'jenis_surat_tugas',
        'perihal_surat_tugas',
        'sifat_nota_dinas',
        'keamanan_nota_dinas',
        'tempat_tugas',
        'tanggal_tugas',
        'tanggal_selesai_tugas',
        'tembusan_surat_tugas',
        'file_surat_tugas',
        'perekam_id',
        'created_at'
    ];

    protected $appends = ['jenis_surat'];

    public function getJenisSuratAttribute()
    {
        return 'SuratTugas';
    }
    public function seksi()
    {
        return $this->belongsTo(Seksi::class, 'seksi_id', 'id');
    }

    public function penugasan()
    {
        return $this->hasMany(Penugasan::class, 'id_surat_tugas');
    }

    public function tembusan()
    {
        return $this->hasMany(Tembusan::class, 'id_surat_tugas');
    }

    public function klasifikasi_surat()
    {
        return $this->belongsTo(KlasifikasiSurat::class, 'klasifikasi_surat_id', 'id');
    }
}