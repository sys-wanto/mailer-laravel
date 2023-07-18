<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\TrackSurat;
use App\Models\User;
use App\Models\Seksi;
use App\Models\KlasifikasiSurat;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;

class SuratKeluarController extends Controller
{
    private $target_arsip_n_tu = array(
        'staff_tu', 'admin_arsip'
    );

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $surat_keluar = SuratKeluar::get();
        return view('surat_keluar.index', compact('surat_keluar'));
    }

    public function create()
    {
        if (Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $seksi = Seksi::all();
        $klasifikasi_surat = KlasifikasiSurat::all();
        return view('surat_keluar.create', compact('seksi', 'klasifikasi_surat'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $pegawai = Pegawai::where('users_id', '=', $user->id)->first();
        $this->validate($request, [
            'seksi_id' => 'required',
            'klasifikasi_surat_id' => 'required',
            'tanggal_surat_keluar' => 'required|date|max:255',
            'tujuan_surat_keluar' => 'required|string|max:255',
            'perihal_surat_keluar' => 'required|string|max:255',
            'sifat_surat_keluar' => 'required|string',
            'keamanan_surat_keluar' => 'required|string',
        ]);


        if ($request->file('file_surat_keluar') == '') {
            $file_surat_keluar = NULL;
        } else {
            $file = $request->file('file_surat_keluar');
            $dt = Carbon::now();
            $acak = $file->getClientOriginalName();
            $fileName = rand(11111, 99999) . '-' . $dt->format('Y-m-d-H-i-s') . '.' . $acak;
            $request->file('file_surat_keluar')->move("files/surat_keluar", $fileName);
            $file_surat_keluar = $fileName;
        }

        $surat_keluar_baru = SuratKeluar::create([
            'seksi_id' => $request->input('seksi_id'),
            'klasifikasi_surat_id' => $request->input('klasifikasi_surat_id'),
            'tanggal_surat_keluar' => $request->input('tanggal_surat_keluar'),
            'tujuan_surat_keluar' => $request->input('tujuan_surat_keluar'),
            'perihal_surat_keluar' => $request->input('perihal_surat_keluar'),
            'sifat_surat_keluar' => $request->input('sifat_surat_keluar'),
            'keamanan_surat_keluar' => $request->input('keamanan_surat_keluar'),
            'file_surat_keluar' => $file_surat_keluar,
            'perekam_id' => $pegawai->id,
        ]);

        $this->init_track_surat($surat_keluar_baru->id);

        Session::flash('message', 'Berhasil ditambahkan!');
        Session::flash('message_type', 'success');
        return redirect()->route('surat_keluar.index');
    }

    private function init_track_surat($id_surat)
    {
        $user = Auth::user();
        $pegawai = Pegawai::where('users_id', '=', $user->id)->first();

        $waktu = Carbon::now();

        TrackSurat::create([
            'type_surat' => 'SuratKeluar',
            'id_pengirim' => $pegawai->id,
            'urutan' => 0,
            'catatan' => 'Surat / Nota di buat',
            'id_surat' => $id_surat,
            'posisi_surat' => $user->level,
            'tgl_terima' => $waktu->toDateString(),
            'tgl_kirim' => $waktu->toDateString(),
        ]);

        if (in_array($user->level, $this->target_arsip_n_tu)) {

            TrackSurat::create([
                'type_surat' => 'SuratKeluar',
                'urutan' => 1,
                'id_surat' => $id_surat,
                'posisi_surat' => 'staff_arsip',
            ]);

            TrackSurat::create([
                'type_surat' => 'SuratKeluar',
                'urutan' => 2,
                'id_surat' => $id_surat,
                'posisi_surat' => 'kepala_tu',
            ]);

            TrackSurat::create([
                'type_surat' => 'SuratKeluar',
                'urutan' => 3,
                'id_surat' => $id_surat,
                'posisi_surat' => 'kepala_kantor',
            ]);
        } else {

            TrackSurat::create([
                'type_surat' => 'SuratKeluar',
                'urutan' => 1,
                'id_surat' => $id_surat,
                'posisi_surat' => 'kepala_tu',
            ]);

            TrackSurat::create([
                'type_surat' => 'SuratKeluar',
                'urutan' => 2,
                'id_surat' => $id_surat,
                'posisi_surat' => 'kepala_seksi',
            ]);

            TrackSurat::create([
                'type_surat' => 'SuratKeluar',
                'urutan' => 3,
                'id_surat' => $id_surat,
                'posisi_surat' => 'kepala_kantor',
            ]);
        }
    }

    public function show($id)
    {
        if ((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $surat_keluar = SuratKeluar::findOrFail($id);

        return view('surat_keluar.show', compact('surat_keluar'));
    }

    public function edit($id)
    {
        if ((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $surat_keluar = SuratKeluar::findOrFail($id);
        $seksi = Seksi::get();
        $klasifikasi_surat = KlasifikasiSurat::get();
        return view('surat_keluar.edit', compact('surat_keluar', 'seksi', 'klasifikasi_surat'));
    }

    public function update(Request $request, $id)
    {
        $surat_keluar = SuratKeluar::findOrFail($id);

        if ($request->file('file_surat_keluar')) {
            $file = $request->file('file_surat_keluar');
            $dt = Carbon::now();
            $acak = $file->getClientOriginalName();
            $fileName = rand(11111, 99999) . '-' . $dt->format('Y-m-d-H-i-s') . '.' . $acak;
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
        if (Auth::user()->id != $id) {
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