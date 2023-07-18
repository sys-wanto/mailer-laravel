<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\KlasifikasiSurat;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use Excel;
use RealRashid\SweetAlert\Facades\Alert;

class KlasifikasiSurat_KepalaSeksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    public function index()
    {
        if(Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $klasifikasi_surat = KlasifikasiSurat::get();
        return view('kepala_seksi.klasifikasi_surat_index', compact('klasifikasi_surat'));
    }

    public function show($id)
    {
        if((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
    }

        $klasifikasi_surat = KlasifikasiSurat::findOrFail($id);

        return view('kepala_seksi.klasifikasi_surat_show', compact('klasifikasi_surat'));
    }
}