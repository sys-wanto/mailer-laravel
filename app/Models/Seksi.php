<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seksi extends Model
{
    use HasFactory;

    protected $table = 'seksi';
    protected $fillable = ['kode_seksi','nama_seksi'];

    public function jabatan(){
        return $this->hasMany(Jabatan::class, 'seksi_id');
    }

    public function pegawai(){
        return $this->hasMany(Pegawai::class, 'pegawai_id');
    }

    public function surat_keluar(){
        return $this->hasMany(SuratKeluar::class, 'surat_keluar_id');
    }

    public function surat_tugas(){
        return $this->hasMany(SuratTugas::class, 'surat_tugas_id');
    }
}
