<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackSurat extends Model
{
    use HasFactory;

    protected $table = 'track_surats';
    protected $fillable = [
        'type_surat',
        'urutan',
        'id_surat',
        'id_pengirim',
        'id_penerima',
        'posisi_surat',
        'tgl_terima',
        'tgl_kirim',
        'catatan'
    ];

    public function penerima_pegawai()
    {
    	return $this->belongsTo(Pegawai::class,'id_penerima','id');
    }

    public function pengirim_pegawai()
    {
    	return $this->belongsTo(Pegawai::class,'id_pengirim','id');
    }


}