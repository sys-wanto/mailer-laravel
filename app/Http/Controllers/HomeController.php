<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use App\Models\Seksi;
use App\Models\Jabatan;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\NotaDinas;
use App\Models\SuratTugas;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $users = User::get();
        $seksi = Seksi::get();
        $jabatan = Jabatan::get();
        $pegawai = Pegawai::get();
        $surat_masuk = SuratMasuk::get();
        $surat_keluar = SuratKeluar::get();
        $nota_dinas = NotaDinas::get();
        $surat_tugas = SuratTugas::get();
        return view('home', compact('users','seksi', 'jabatan', 'pegawai','surat_masuk','surat_keluar','nota_dinas', 'surat_tugas'));
    }
}
