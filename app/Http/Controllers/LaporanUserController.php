<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seksi;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanUserController extends Controller 
{
    public function __construct() {
        $this -> middleware('auth');
    }

    public function user() {
        return view('laporan_user.user');
    }

    public function userPdf() {

        $users = User::get();
        $seksi = Seksi::get();
        $jabatan = Jabatan::get();
        $pegawai = Pegawai::get();
        $pdf = PDF::loadView('laporan_user.user_pdf', compact('users','seksi','jabatan','pegawai'));
        return $pdf -> download('laporan_user_'.date('Y-m-d_H-i-s').
            '.pdf');
    }
}