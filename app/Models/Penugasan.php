<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    use HasFactory;

    protected $table = 'penugasans';
    protected $fillable = ['id_surat_tugas', 'pegawai_id'];

    public function surat_tugas()
    {
        return $this->hasOne(SuratTugas::class, 'id', 'id_surat_tugas');
    }

    public function pegawai()
    {
        return $this->hasOne(Pegawai::class, 'id', 'pegawai_id');
    }
}