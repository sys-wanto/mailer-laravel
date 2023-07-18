<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NomorSurat extends Model
{
    use HasFactory;

    protected $table = 'nomor_surats';
    protected $fillable = ['type_surat','tahun_terbit','bulan_terbit','nomor_urut'];

}
