<?php

namespace App\Http\Controllers;

use App\Models\Penugasan;
use App\Models\Tembusan;
use App\Models\TrackSurat;
use App\Models\User;
use App\Models\Seksi;
use App\Models\Pegawai;
use App\Models\KlasifikasiSurat;
use App\Models\SuratTugas;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SuratTugasController extends Controller
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

        $surat_tugas = SuratTugas::get();
        // $surat_tugas = DB::select(DB::raw('select
        //     `surat_tugas` .*,
        //     GROUP_CONCAT(pegawai.nama) pegawai
        // from
        //     `surat_tugas`
        // inner join `penugasans` on
        //     `penugasans`.`id_surat_tugas` = `surat_tugas`.`id`
        // inner join `pegawai` on
        //     `pegawai`.`id` = `penugasans`.`pegawai_id`'));
        return view('surat_tugas.index', compact('surat_tugas'));
    }

    public function create()
    {
        if (Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $seksi = Seksi::all();
        $pegawai = Pegawai::all();
        $klasifikasi_surat = KlasifikasiSurat::all();
        return view('surat_tugas.create', compact('seksi', 'pegawai', 'klasifikasi_surat'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $pegawai = Pegawai::where('users_id', '=', $user->id)->first();
        $this->validate($request, [
            'seksi_id' => 'required',
            'klasifikasi_surat_id' => 'required',
            'tanggal_surat_tugas' => 'required|date|max:255',
            'jenis_surat_tugas' => 'required|string|max:255',
            'perihal_surat_tugas' => 'required|string|max:255',
            'sifat_surat_tugas' => 'required|string|max:255',
            'keamanan_surat_tugas' => 'required|string|max:255',
            'tempat_tugas' => 'required|string|max:255',
            'tanggal_tugas' => 'required|date|max:255',
            'tanggal_selesai_tugas' => 'required|date|max:255',
            'file_surat_tugas' => 'required|mimes:pdf|max:10000',
        ]);


        if ($request->file('file_surat_tugas') == '') {
            $file_surat_tugas = NULL;
        } else {
            $file = $request->file('file_surat_tugas');
            $dt = Carbon::now();
            $acak = $file->getClientOriginalName();
            $fileName = rand(11111, 99999) . '-' . $dt->format('Y-m-d-H-i-s') . '.' . $acak;
            $request->file('file_surat_tugas')->move("files/surat_tugas", $fileName);
            $file_surat_tugas = $fileName;
        }

        $surat_tugas_baru = SuratTugas::create([
            'seksi_id' => $request->input('seksi_id'),
            'klasifikasi_surat_id' => $request->input('klasifikasi_surat_id'),
            'tanggal_surat_tugas' => $request->input('tanggal_surat_tugas'),
            'jenis_surat_tugas' => $request->input('jenis_surat_tugas'),
            'perihal_surat_tugas' => $request->input('perihal_surat_tugas'),
            'sifat_surat_tugas' => $request->input('sifat_surat_tugas'),
            'keamanan_surat_tugas' => $request->input('keamanan_surat_tugas'),
            'tempat_tugas' => $request->input('tempat_tugas'),
            'tanggal_tugas' => $request->input('tanggal_tugas'),
            'tanggal_selesai_tugas' => $request->input('tanggal_selesai_tugas'),
            'file_surat_tugas' => $file_surat_tugas,
            'perekam_id' => $pegawai->id,
        ]);

        $this->tugaskan_pegawai($surat_tugas_baru->id, $request->pegawai_ditugaskan);
        $this->tembusan_pegawai($surat_tugas_baru->id, $request->pegawai_tembusan);

        $this->init_track_surat($surat_tugas_baru->id);

        Session::flash('message', 'Berhasil ditambahkan!');
        Session::flash('message_type', 'success');
        return redirect()->route('surat_tugas.index');

    }

    private function tugaskan_pegawai($surat_tugas, $pegawai_ditugaskan)
    {
        foreach ($pegawai_ditugaskan as $key => $petugas) {
            Penugasan::create([
                'id_surat_tugas' => $surat_tugas,
                'pegawai_id' => $petugas
            ]);
        }
    }

    private function tembusan_pegawai($surat_tugas, $pegawai_tembusan)
    {
        foreach ($pegawai_tembusan as $key => $petugas) {
            Tembusan::create([
                'id_surat_tugas' => $surat_tugas,
                'pegawai_id' => $petugas
            ]);
        }
    }

    private function init_track_surat($id_surat)
    {
        $user = Auth::user();
        $pegawai = Pegawai::where('users_id', '=', $user->id)->first();

        $waktu = Carbon::now();

        TrackSurat::create([
            'type_surat' => 'SuratTugas',
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
                'type_surat' => 'SuratTugas',
                'urutan' => 1,
                'id_surat' => $id_surat,
                'posisi_surat' => 'staff_arsip',
            ]);

            TrackSurat::create([
                'type_surat' => 'SuratTugas',
                'urutan' => 2,
                'id_surat' => $id_surat,
                'posisi_surat' => 'kepala_tu',
            ]);

            TrackSurat::create([
                'type_surat' => 'SuratTugas',
                'urutan' => 3,
                'id_surat' => $id_surat,
                'posisi_surat' => 'kepala_kantor',
            ]);
        } else {

            TrackSurat::create([
                'type_surat' => 'SuratTugas',
                'urutan' => 1,
                'id_surat' => $id_surat,
                'posisi_surat' => 'kepala_tu',
            ]);

            TrackSurat::create([
                'type_surat' => 'SuratTugas',
                'urutan' => 2,
                'id_surat' => $id_surat,
                'posisi_surat' => 'kepala_seksi',
            ]);

            TrackSurat::create([
                'type_surat' => 'SuratTugas',
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

        $surat_tugas = SuratTugas::findOrFail($id);

        return view('surat_tugas.show', compact('surat_tugas'));
    }

    public function edit($id)
    {
        if ((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $surat_tugas = SuratTugas::findOrFail($id);
        $ditugaskan = [];
        foreach($surat_tugas->penugasan as $key => $val){
            $ditugaskan[] = $val->pegawai_id;
        }
        $seksi = Seksi::get();
        $pegawai = Pegawai::get();
        $klasifikasi_surat = KlasifikasiSurat::get();
        return view('surat_tugas.edit', compact('surat_tugas', 'seksi', 'pegawai', 'klasifikasi_surat','ditugaskan'));
    }

    public function update(Request $request, $id)
    {
        $surat_tugas = SuratTugas::findOrFail($id);

        if ($request->file('file_surat_tugas')) {
            $file = $request->file('file_surat_tugas');
            $dt = Carbon::now();
            $acak = $file->getClientOriginalName();
            $fileName = rand(11111, 99999) . '-' . $dt->format('Y-m-d-H-i-s') . '.' . $acak;
            $request->file('file_surat_tugas')->move("files/surat_tugas", $fileName);
            $surat_tugas->file_surat_tugas = $fileName;
        }

        $surat_tugas->seksi_id = $request->input('seksi_id');
        $surat_tugas->pegawai_id = $request->input('pegawai_id');
        $surat_tugas->klasifikasi_surat_id = $request->input('klasifikasi_surat_id');
        $surat_tugas->tanggal_surat_tugas = $request->input('tanggal_surat_tugas');
        $surat_tugas->jenis_surat_tugas = $request->input('jenis_surat_tugas');
        $surat_tugas->perihal_surat_tugas = $request->input('perihal_surat_tugas');
        $surat_tugas->tempat_tugas = $request->input('tempat_tugas');
        $surat_tugas->tanggal_tugas = $request->input('tanggal_tugas');
        $surat_tugas->tanggal_selesai_tugas = $request->input('tanggal_selesai_tugas');
        $surat_tugas->file_surat_tugas = $request->input('file_surat_tugas');

        $surat_tugas->update();

        Session::flash('message', 'Berhasil diubah!');
        Session::flash('message_type', 'success');
        return redirect()->to('surat_tugas');
    }

    public function destroy($id)
    {
        if (Auth::user()->id != $id) {
            $surat_tugas = SuratTugas::findOrFail($id);
            $surat_tugas->delete();
            Session::flash('message', 'Berhasil dihapus!');
            Session::flash('message_type', 'success');
        } else {
            Session::flash('message', 'Akun anda sendiri tidak bisa dihapus!');
            Session::flash('message_type', 'danger');
        }
        return redirect()->to('surat_tugas');
    }
}