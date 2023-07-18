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

class KlasifikasiSuratController extends Controller
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
        return view('klasifikasi_surat.index', compact('klasifikasi_surat'));
    }

    public function create()
    {
        if(Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        return view('klasifikasi_surat.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kode_klasifikasi' => 'required|string|max:255',
            'nama_klasifikasi' => 'required|string|max:255',
            'uraian' => 'required|string|max:255'
        ]);

        KlasifikasiSurat::create([
                'kode_klasifikasi' => $request->get('kode_klasifikasi'),
                'nama_klasifikasi' => $request->get('nama_klasifikasi'),
                'uraian' => $request->get('uraian'),
            ]);

        alert()->success('Berhasil.','Data telah ditambahkan!');

        return redirect()->route('klasifikasi_surat.index');

    }

    public function show($id)
    {
        if((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
    }

        $klasifikasi_surat = KlasifikasiSurat::findOrFail($id);

        return view('klasifikasi_surat.show', compact('klasifikasi_surat'));
    }

    public function edit($id)
    {   
        if((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
    }

        $klasifikasi_surat = KlasifikasiSurat::findOrFail($id);
        return view('klasifikasi_surat.edit', compact('klasifikasi_surat'));
    }

    public function update(Request $request, $id)
    {
        KlasifikasiSurat::find($id)->update([
            'kode_klasifikasi' => $request->get('kode_klasifikasi'),
            'nama_klasifikasi' => $request->get('nama_klasifikasi'),
            'uraian' => $request->get('uraian'),
        ]);

        alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->route('klasifikasi_surat.index');
    }

    public function destroy($id)
    {
        KlasifikasiSurat::find($id)->delete();
        alert()->success('Berhasil.','Data telah dihapus!');
        return redirect()->route('klasifikasi_surat.index');
    }
}