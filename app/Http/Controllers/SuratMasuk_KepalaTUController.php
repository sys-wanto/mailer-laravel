<?php

namespace App\Http\Controllers;

use App\Models\TrackSurat;
use App\Models\User;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SuratMasuk_KepalaTUController extends Controller
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
        
        $user = Auth::user();
        $track_surats = TrackSurat::where('posisi_surat', '=', $user->level)->where('urutan','=','1')->get();
        // dd($track_surats);
        $track_surat_lengkap = TrackSurat::all()->toArray();
        $collections = array();
        foreach ($track_surats as $key => $track_surat) {
            if ($track_surat->type_surat == 'SuratMasuk') {
                $ids = array_search($track_surat->posisi_surat, array_column($track_surat_lengkap, 'posisi_surat'));
                $surat_masuk = SuratMasuk::where('id', '=', $track_surat->id_surat)->first()->toArray();
                $surat_masuk['tgl_terima'] = $track_surat->tgl_terima;
                $surat_masuk['tgl_kirim'] = $track_surat->tgl_kirim;
                $surat_masuk['posisi_surat'] = $track_surat->posisi_surat;
                $surat_masuk['disposed'] = $track_surat->tgl_kirim=='0000-00-00'?false:true;
                $surat_masuk['asal'] = $track_surat_lengkap[$ids - 1]['posisi_surat'];
                $collections[] = $surat_masuk;
            }
        }
        return view('kepala_tu.surat_masuk_index', compact('collections'));
    }

    public function show($id)
    {
        if((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $surat_masuk = SuratMasuk::findOrFail($id);

        return view('kepala_tu.surat_masuk_show', compact('surat_masuk'));
    }
}
