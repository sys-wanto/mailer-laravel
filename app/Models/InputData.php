<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputData extends Model
{
    use HasFactory;

    protected $table = 'input_data';
    protected $fillable = ['data_utama_id', 'jenis_data_id','kategori_data_id', 'jumlah_data', 'tahun_data_id'];
    
    public function data_utama()
    {
        return $this->belongsTo(DataUtama::class, 'data_utama_id', 'id');
    }

    public function jenis_data()
    {
        return $this->belongsTo(JenisData::class, 'jenis_data_id', 'id');
    }

    public function kategori_data()
    {
        return $this->belongsTo(KategoriData::class, 'kategori_data_id', 'id');
    }

    public function tahun_data()
    {
        return $this->belongsTo(TahunData::class, 'tahun_data_id', 'id');
    }
}
