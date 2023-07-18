<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';
    protected $fillable = [
        'asal_surat_masuk', 
        'nomor_surat_masuk', 
        'tanggal_surat_masuk', 
        'lampiran_surat_masuk', 
        'perihal_surat_masuk', 
        'sifat_surat_masuk', 
        'keamanan_surat_masuk', 
        'barcode_surat_masuk', 
        'file_surat_masuk',
        'rak_penyimpanan_id',
        'perekam_id',
    ];

    public function disposisi()
    {
        return $this->hasOne(Disposisi::class, 'disposisi_id');
    }

    public function rak_penyimpanan()
    {
        return $this->belongsTo(KlasifikasiSurat::class, 'rak_penyimpanan_id', 'id');
    }

    public function perekam()
    {
        return $this->belongsTo(Pegawai::class, 'perekam_id', 'id');
    }
}
