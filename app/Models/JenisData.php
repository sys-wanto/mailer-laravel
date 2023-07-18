<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisData extends Model
{
    use HasFactory;

    protected $table = 'jenis_data';
    protected $fillable = ['data_utama_id', 'nama_jenis_data'];

    public function data_utama()
    {
        return $this->belongsTo(DataUtama::class, 'data_utama_id');
    }

    public function kategori_datas(){
        return $this->hasMany(KategoriData::class, 'jenis_data_id');
    }
}
