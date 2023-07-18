<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\NotaDinas;
use App\Models\SuratTugas;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanSuratController extends Controller 
{
    public function __construct() {
        $this -> middleware('auth');
    }

    public function surat() {
        return view('laporan_surat.surat');
    }

    public function suratPdf() {

        $surat_masuk = SuratMasuk::get();
        $surat_keluar = SuratKeluar::get();
        $nota_dinas = NotaDinas::get();
        $surat_tugas = SuratTugas::get();
        $pdf = PDF::loadView('laporan_surat.surat_pdf', compact('surat_masuk','surat_keluar','nota_dinas','surat_tugas'));
        return $pdf -> download('laporan_surat_'.date('Y-m-d_H-i-s').
            '.pdf');
    }
}