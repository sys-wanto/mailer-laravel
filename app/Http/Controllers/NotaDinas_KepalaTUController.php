<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seksi;
use App\Models\KlasifikasiSurat;
use App\Models\NotaDinas;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;

class NotaDinas_KepalaTUController extends Controller
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

        $nota_dinas = NotaDinas::get();
        return view('kepala_tu.nota_dinas_index', compact('nota_dinas'));
    }

    public function create()
    {
        if(Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $seksi = Seksi::all();
        $klasifikasi_surat = KlasifikasiSurat::all();
        return view('kepala_tu.nota_dinas_create', compact('seksi', 'klasifikasi_surat'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'seksi_id' => 'required',
            'klasifikasi_surat_id' => 'required',
            'tanggal_nota_dinas' => 'required|date|max:255',
            'tujuan_nota_dinas' => 'required|string|max:255',
            'perihal_nota_dinas' => 'required|string|max:255',
            'sifat_nota_dinas' => 'required|string|max:255',
            'keamanan_nota_dinas' => 'required|string|max:255',
            'file_nota_dinas' => 'required|mimes:pdf|max:10000',
        ]);

        if($request->file('file_nota_dinas') == '') {
            $file_nota_dinas = NULL;
        } else {
            $file = $request->file('file_nota_dinas');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalName();
            $fileName = rand(11111,99999).'-'.$dt->format('Y-m-d-H-i-s').'.'.$acak; 
            $request->file('file_nota_dinas')->move("files/nota_dinas", $fileName);
            $file_nota_dinas = $fileName;
        }

        NotaDinas::create([
            'seksi_id' => $request->input('seksi_id'),
            'klasifikasi_surat_id' => $request->input('klasifikasi_surat_id'),
            'tanggal_nota_dinas' => $request->input('tanggal_nota_dinas'),
            'tujuan_nota_dinas' => $request->input('tujuan_nota_dinas'),
            'perihal_nota_dinas' => $request->input('perihal_nota_dinas'),
            'sifat_nota_dinas' => $request->input('sifat_nota_dinas'),
            'keamanan_nota_dinas' => $request->input('keamanan_nota_dinas'),
            'file_nota_dinas' => $file_nota_dinas
        ]);

        Session::flash('message', 'Berhasil ditambahkan!');
        Session::flash('message_type', 'success');
        return redirect()->route('kepala_tu.nota_dinas_index');

    }

    public function edit($id)
    {   
        if((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $nota_dinas = NotaDinas::findOrFail($id);
        $seksi = Seksi::get();
        $klasifikasi_surat = KlasifikasiSurat::get();
        return view('kepala_tu.nota_dinas_edit', compact('nota_dinas', 'seksi', 'klasifikasi_surat'));
    }

    public function update(Request $request, $id)
    {
        $nota_dinas = NotaDinas::findOrFail($id);

        if($request->file('file_nota_dinas')) 
        {
            $file = $request->file('file_nota_dinas');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalName();
            $fileName = rand(11111,99999).'-'.$dt->format('Y-m-d-H-i-s').'.'.$acak; 
            $request->file('file_nota_dinas')->move("files/nota_dinas", $fileName);
            $nota_dinas->file_nota_dinas = $fileName;
        }

        $nota_dinas->seksi_id = $request->input('seksi_id');
        $nota_dinas->klasifikasi_surat_id = $request->input('klasifikasi_surat_id');
        $nota_dinas->tanggal_nota_dinas = $request->input('tanggal_nota_dinas');
        $nota_dinas->tujuan_nota_dinas = $request->input('tujuan_nota_dinas');
        $nota_dinas->perihal_nota_dinas = $request->input('perihal_nota_dinas');
        $nota_dinas->sifat_nota_dinas = $request->input('sifat_nota_dinas');
        $nota_dinas->keamanan_nota_dinas = $request->input('keamanan_nota_dinas');
        $nota_dinas->file_nota_dinas = $request->input('file_nota_dinas');

        $nota_dinas->update();

        Session::flash('message', 'Berhasil diubah!');
        Session::flash('message_type', 'success');
        return redirect()->to('nota_dinas');
    }

    public function destroy($id)
    {
        if(Auth::user()->id != $id) {
            $nota_dinas = NotaDinas::findOrFail($id);
            $nota_dinas->delete();
            Session::flash('message', 'Berhasil dihapus!');
            Session::flash('message_type', 'success');
        } else {
            Session::flash('message', 'Akun anda sendiri tidak bisa dihapus!');
            Session::flash('message_type', 'danger');
        }
        return redirect()->to('nota_dinas');
    }
}
