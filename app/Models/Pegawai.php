<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $fillable = ['users_id', 'seksi_id', 'jabatan_id', 'nama', 'nip', 'status_pegawai'];


    /**
     * Method One To One 
     */
    public function users()
    {
    	return $this->belongsTo(User::class);
    }

    public function seksi()
    {
        return $this->belongsTo(Seksi::class, 'seksi_id', 'id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id');
    }

    public function surat_tugas()
    {
        return $this->hasMany(SuratTugas::class, 'surat_tugas_id');
    }

    public function disposisi()
    {
        return $this->hasMany(Disposisi::class, 'disposisi_id');
    }

    public function surat_keluar()
    {
        return $this->hasMany(SuratKeluar::class,'surat_keluar_id');
    }

}
