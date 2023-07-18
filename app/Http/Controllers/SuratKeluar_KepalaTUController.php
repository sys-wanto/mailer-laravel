<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seksi;
use App\Models\KlasifikasiSurat;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SuratKeluar_KepalaTUController extends Controller
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

        $surat_keluar = SuratKeluar::get();
        return view('kepala_tu.surat_keluar_index', compact('surat_keluar'));
    }

    public function create()
    {
        if(Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $seksi = Seksi::all();
        $klasifikasi_surat = KlasifikasiSurat::all();
        return view('kepala_tu.surat_keluar_create', compact('seksi', 'klasifikasi_surat'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'seksi_id' => 'required',
            'klasifikasi_surat_id' => 'required',
            'tanggal_surat_keluar' => 'required|date|max:255',
            'tujuan_surat_keluar' => 'required|string|max:255',
            'perihal_surat_keluar' => 'required|string|max:255',
            'sifat_surat_keluar' => 'required|string',
            'keamanan_surat_keluar' => 'required|string',
        ]);


        if($request->file('file_surat_keluar') == '') {
            $file_surat_keluar = NULL;
        } else {
            $file = $request->file('file_surat_keluar');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalName();
            $fileName = rand(11111,99999).'-'.$dt->format('Y-m-d-H-i-s').'.'.$acak; 
            $request->file('file_surat_keluar')->move("files/surat_keluar", $fileName);
            $file_surat_keluar = $fileName;
        }

        SuratKeluar::create([
            'seksi_id' => $request->input('seksi_id'),
            'klasifikasi_surat_id' => $request->input('klasifikasi_surat_id'),
            'tanggal_surat_keluar' => $request->input('tanggal_surat_keluar'),
            'tujuan_surat_keluar' => $request->input('tujuan_surat_keluar'),
            'perihal_surat_keluar' => $request->input('perihal_surat_keluar'),
            'sifat_surat_keluar' => $request->input('sifat_surat_keluar'),
            'keamanan_surat_keluar' => $request->input('keamanan_surat_keluar'),
            'file_surat_keluar' => $file_surat_keluar
        ]);
        
        Session::flash('message', 'Berhasil ditambahkan!');
        Session::flash('message_type', 'success');
        return redirect()->route('kepala_tu.surat_keluar_index');

    }

    public function show($id)
    {
        if((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $surat_keluar = SuratKeluar::findOrFail($id);

        return view('kepala_tu.surat_keluar_show', compact('surat_keluar'));
    }

    public function edit($id)
    {   
        if((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $surat_keluar = SuratKeluar::findOrFail($id);
        $seksi = Seksi::get();
        $klasifikasi_surat = KlasifikasiSurat::get();
        return view('kepala_tu.surat_keluar_edit', compact('surat_keluar', 'seksi', 'klasifikasi_surat'));
    }

    public function update(Request $request, $id)
    {
        $surat_keluar = SuratKeluar::findOrFail($id);

        if($request->file('file_surat_keluar')) 
        {
            $file = $request->file('file_surat_keluar');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalName();
            $fileName = rand(11111,99999).'-'.$dt->format('Y-m-d-H-i-s').'.'.$acak; 
            $request->file('file_surat_keluar')->move("files/surat_keluar", $fileName);
            $surat_keluar->file_surat_keluar = $fileName;
        }

        $surat_keluar->seksi_id = $request->input('seksi_id');
        $surat_keluar->klasifikasi_surat_id = $request->input('klasifikasi_surat_id');
        $surat_keluar->tanggal_surat_keluar = $request->input('tanggal_surat_keluar');
        $surat_keluar->tujuan_surat_keluar = $request->input('tujuan_surat_keluar');
        $surat_keluar->perihal_surat_keluar = $request->input('perihal_surat_keluar');
        $surat_keluar->sifat_surat_keluar = $request->input('sifat_surat_keluar');
        $surat_keluar->keamanan_surat_keluar = $request->input('keamanan_surat_keluar');
        $surat_keluar->file_surat_keluar = $request->input('file_surat_keluar');

        $surat_keluar->update();

        Session::flash('message', 'Berhasil diubah!');
        Session::flash('message_type', 'success');
        return redirect()->to('surat_keluar');
    }

    public function destroy($id)
    {
        if(Auth::user()->id != $id) {
            $surat_keluar = SuratKeluar::findOrFail($id);
            $surat_keluar->delete();
            Session::flash('message', 'Berhasil dihapus!');
            Session::flash('message_type', 'success');
        } else {
            Session::flash('message', 'Akun anda sendiri tidak bisa dihapus!');
            Session::flash('message_type', 'danger');
        }
        return redirect()->to('surat_keluar');
    }
}
