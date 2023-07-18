<?php

namespace App\Http\Controllers;

use App\Models\NotaDinas;
use App\Models\Pegawai;
use App\Models\SuratKeluar;
use App\Models\SuratTugas;
use App\Models\TrackSurat;
use App\Models\SuratMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersetujuanController extends Controller
{
    private $posisi_kepala = array(
        'kepala_tu',
        'kepala_arsip'
    );

    public $posisi = array(
        'kepala_tu' => 'Kepala TU',
        'staff_tu' => 'Staff TU',
        'admin_user' => 'Admin User',
        'admin_data' => 'Admin Data',
        'admin_arsip' => 'Admin Arsip',
        'staff_arsip' => 'Staff Arsip',
        'kepala_kantor' => 'Kepala Kantor',
        'kepala_seksi' => 'Kepala Seksi',
        'staff_seksi' => 'Staff Seksi'
    );

    public $kepala = array(
        'kepala_tu',
        'kepala_seksi'
    );

    public $staff = array(
        'staff_seksi',
        'staff_tu'
    );

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $user = DB::table('pegawai')->select('users.level', 'pegawai.id', 'pegawai.seksi_id')->join('users', 'users.id', '=', 'pegawai.users_id')->where('pegawai.users_id', $user->id)->first();
        if (in_array($user->level, $this->kepala)) {
            $track_surats = TrackSurat::where('posisi_surat', '=', $user->level)->join('pegawai', 'pegawai.id', '=', 'track_surats.id_pengirim')->where('tgl_kirim', '=', '0000-00-00')->where('tgl_terima', '<>', '0000-00-00')->where('pegawai.seksi_id', '=', $user->seksi_id)->where('track_surats.id_pengirim', '=', $user->id)->get();
        } else {
            $track_surats = TrackSurat::where('posisi_surat', '=', $user->level)->join('pegawai', 'pegawai.id', '=', 'track_surats.id_pengirim')->where('tgl_kirim', '=', '0000-00-00')->where('tgl_terima', '<>', '0000-00-00')->where('pegawai.seksi_id', '=', $user->seksi_id)->get();
        }
        $collections = array();
        foreach ($track_surats as $key => $track_surat) {
            if ($track_surat->type_surat == 'SuratKeluar') {
                $surat_keluar = SuratKeluar::where('surat_keluar.id', '=', $track_surat->id_surat)->first()->toArray();
                $pembuat_surat = Pegawai::where('id', '=', $surat_keluar['perekam_id'])->first();
                if ($track_surat->urutan - 1 >= 0) {
                    $track_surat_mundur = TrackSurat::where('urutan', '=', ($track_surat->urutan - 1))->where('type_surat','=','SuratKeluar')->first();
                    $pengirim = $pegawai_user = DB::table('pegawai')->where('id', $track_surat_mundur->id_pengirim)->first();
                    $pengirim = $pengirim->nama;
                    $catatans = $track_surat_mundur->catatan;
                } else {
                    $pengirim = $pembuat_surat->nama;
                    $catatans = 'Surat di buat';
                }
                $surat_keluar['type_surat_n_id'] = $track_surat->type_surat . '-' . $track_surat->id_surat;
                $surat_keluar['pengirim'] = $pengirim;
                $surat_keluar['tgl_terima'] = $track_surat->tgl_terima;
                $surat_keluar['posisi_surat'] = $track_surat->posisi_surat;
                $surat_keluar['sifat_surat'] = $surat_keluar['sifat_surat_keluar'];
                $surat_keluar['tgl_kirim'] = $track_surat->tgl_kirim;
                $surat_keluar['catatan'] = $catatans;
                $surat_keluar['file'] = asset('files/surat_keluar/' . $surat_keluar['file_surat_keluar']);
                $collections[] = $surat_keluar;
            } else
                if ($track_surat->type_surat == 'NotaDinas') {
                    $nota_dinas = NotaDinas::where('nota_dinas.id', '=', $track_surat->id_surat)->first()->toArray();
                    $pembuat_surat = Pegawai::where('id', '=', $nota_dinas['perekam_id'])->first();
                    if ($track_surat->urutan - 1 >= 0) {
                        $track_surat_mundur = TrackSurat::where('urutan', '=', ($track_surat->urutan - 1))->where('type_surat','=','NotaDinas')->first();
                        $pengirim = $pegawai_user = DB::table('pegawai')->where('id', $track_surat_mundur->id_pengirim)->first();
                        $pengirim = $pengirim->nama;
                        $catatans = $track_surat_mundur->catatan;
                    } else {
                        $pengirim = $pembuat_surat->nama;
                        $catatans = 'Surat di buat';
                    }
                    $nota_dinas['type_surat_n_id'] = $track_surat->type_surat . '-' . $track_surat->id_surat;
                    $nota_dinas['pengirim'] = $pengirim;
                    $nota_dinas['tgl_terima'] = $track_surat->tgl_terima;
                    $nota_dinas['posisi_surat'] = $track_surat->posisi_surat;
                    $nota_dinas['sifat_surat'] = $nota_dinas['sifat_nota_dinas'];
                    $nota_dinas['tgl_kirim'] = $track_surat->tgl_kirim;
                    $nota_dinas['catatan'] = $catatans;
                    $nota_dinas['file'] = asset('files/nota_dinas/' . $nota_dinas['file_nota_dinas']);
                    $collections[] = $nota_dinas;
                } else
                    if ($track_surat->type_surat == 'SuratTugas') {
                        $surat_tugas = SuratTugas::where('surat_tugas.id', '=', $track_surat->id_surat)->first()->toArray();
                        $pembuat_surat = Pegawai::where('id', '=', $surat_tugas['perekam_id'])->first();
                        if ($track_surat->urutan - 1 >= 0) {
                            $track_surat_mundur = TrackSurat::where('urutan', '=', ($track_surat->urutan - 1))->where('type_surat','=','SuratTugas')->first();
                            $pengirim = $pegawai_user = DB::table('pegawai')->where('id', $track_surat_mundur->id_pengirim)->first();
                            $pengirim = $pengirim->nama;
                            $catatans = $track_surat_mundur->catatan;
                        } else {
                            $pengirim = $pembuat_surat->nama;
                            $catatans = 'Surat di buat';
                        }
                        
                        $surat_tugas['type_surat_n_id'] = $track_surat->type_surat . '-' . $track_surat->id_surat;
                        $surat_tugas['pengirim'] = $pengirim;
                        $surat_tugas['tgl_terima'] = $track_surat->tgl_terima;
                        $surat_tugas['posisi_surat'] = $track_surat->posisi_surat;
                        $surat_tugas['sifat_surat'] = $surat_tugas['sifat_surat_tugas'];
                        $surat_tugas['tgl_kirim'] = $track_surat->tgl_kirim;
                        $surat_tugas['catatan'] = $catatans;
                        $surat_tugas['file'] = asset('files/surat_tugas/' . $surat_tugas['file_surat_tugas']);
                        $collections[] = $surat_tugas;
                    }
        }
        return view('persetujuan.index', compact('collections'), compact('user'));
    }

    public function done()
    {
        $user = Auth::user();
        // $user = DB::table('pegawai')->select()->join('users', 'users.id', '=', 'pegawai.users_id')->where('users_id', $user->id)->first();
        $user = DB::table('pegawai')->select('users.level', 'pegawai.id', 'pegawai.seksi_id')->join('users', 'users.id', '=', 'pegawai.users_id')->where('pegawai.users_id', $user->id)->first();
        if (in_array($user->level, $this->kepala)) {
            $track_surats = TrackSurat::where('posisi_surat', '=', $user->level)->join('pegawai', 'pegawai.id', '=', 'track_surats.id_pengirim')->where('tgl_kirim', '<>', '0000-00-00')->where('tgl_terima', '<>', '0000-00-00')->where('pegawai.seksi_id', '=', $user->seksi_id)->where('track_surats.id_pengirim', '=', $user->id)->get();
        } else {
            $track_surats = TrackSurat::where('posisi_surat', '=', $user->level)->join('pegawai', 'pegawai.id', '=', 'track_surats.id_pengirim')->where('tgl_kirim', '<>', '0000-00-00')->where('tgl_terima', '<>', '0000-00-00')->where('pegawai.seksi_id', '=', $user->seksi_id)->get();
        }

        // $track_surats = TrackSurat::where('posisi_surat', '=', $user->level)->where('tgl_kirim', '<>', '0000-00-00')->where('tgl_terima', '<>', '0000-00-00')->get();
        $track_surat_lengkap = TrackSurat::all();
        $collections = array();
        foreach ($track_surats as $key => $track_surat) {
            if ($track_surat->type_surat == 'SuratKeluar') {
                $surat_keluar = SuratKeluar::where('surat_keluar.id', '=', $track_surat->id_surat)->first()->toArray();
                $surat_keluar['type_surat_n_id'] = $track_surat->type_surat . '-' . $track_surat->id_surat;
                $surat_keluar['pengirim'] = $track_surat->pengirim_pegawai->nama;
                $surat_keluar['tgl_terima'] = $track_surat->tgl_terima;
                $surat_keluar['posisi_surat'] = $track_surat->posisi_surat;
                $surat_keluar['sifat_surat'] = $surat_keluar['sifat_surat_keluar'];
                $surat_keluar['tgl_kirim'] = $track_surat->tgl_kirim;
                $surat_keluar['catatan'] = $track_surat->catatan;
                $surat_keluar['file'] = asset('files/surat_keluar/' . $surat_keluar['file_surat_keluar']);
                $collections[] = $surat_keluar;
            } else
                if ($track_surat->type_surat == 'NotaDinas') {
                    $nota_dinas = NotaDinas::where('nota_dinas.id', '=', $track_surat->id_surat)->first()->toArray();
                    $nota_dinas['type_surat_n_id'] = $track_surat->type_surat . '-' . $track_surat->id_surat;
                    $nota_dinas['pengirim'] = $track_surat->pengirim_pegawai->nama;
                    $nota_dinas['tgl_terima'] = $track_surat->tgl_terima;
                    $nota_dinas['posisi_surat'] = $track_surat->posisi_surat;
                    $nota_dinas['sifat_surat'] = $nota_dinas['sifat_nota_dinas'];
                    $nota_dinas['tgl_kirim'] = $track_surat->tgl_kirim;
                    $nota_dinas['catatan'] = $track_surat->catatan;
                    $nota_dinas['file'] = asset('files/nota_dinas/' . $nota_dinas['file_nota_dinas']);
                    $collections[] = $nota_dinas;
                } else
                    if ($track_surat->type_surat == 'SuratTugas') {
                        $surat_tugas = SuratTugas::where('surat_tugas.id', '=', $track_surat->id_surat)->first()->toArray();
                        $surat_tugas['type_surat_n_id'] = $track_surat->type_surat . '-' . $track_surat->id_surat;
                        $surat_tugas['pengirim'] = $track_surat->pengirim_pegawai->nama;
                        $surat_tugas['tgl_terima'] = $track_surat->tgl_terima;
                        $surat_tugas['posisi_surat'] = $track_surat->posisi_surat;
                        $surat_tugas['sifat_surat'] = $surat_tugas['sifat_surat_tugas'];
                        $surat_tugas['tgl_kirim'] = $track_surat->tgl_kirim;
                        $surat_tugas['catatan'] = $track_surat->catatan;
                        $surat_tugas['file'] = asset('files/surat_tugas/' . $surat_tugas['file_surat_tugas']);
                        $collections[] = $surat_tugas;
                    }
        }
        return view('persetujuan.done', compact('collections'), compact('user'));
    }

    public function kepala()
    {

        $user = Auth::user();
        $pegawai_user = DB::table('pegawai')->where('users_id', $user->id)->first();
        $user_data = DB::table('users')->select('pegawai.id', 'pegawai.nama AS name')->join('pegawai', 'users.id', '=', 'pegawai.users_id');
        if ($user->level == 'staff_seksi') {
            $user_data->where('users.level', '=', 'kepala_seksi')->where('pegawai.seksi_id', '=', $pegawai_user->seksi_id);
        } else
            if ($user->level == 'staff_tu') {
                $user_data->where('users.level', '=', 'kepala_tu')->where('pegawai.seksi_id', '=', $pegawai_user->seksi_id);
            } else
                if (in_array($user->level, $this->kepala)) {
                    $user_data->where('users.level', '=', 'kepala_kantor');
                }
        if ($user_data->count() >= 1) {
            $feedback = array(
                'is_error' => false,
                'data' => $user_data->get(),
                'msg' => 'sukses'
            );
        } else {
            $feedback = array(
                'is_error' => true,
                'data' => array('TIDAK ADA'),
                'msg' => 'sukses'
            );
        }
        return response()->json($feedback, 200, array(), JSON_PRETTY_PRINT);
    }

    public function track($id_surat)
    {
        //explode untuk mendapatkan id surat & type surat;
        $surat_ = explode('-', $id_surat);
        //$surat_[1] = id surat;
        //$surat_[0] = type surat;

        $track_surat = TrackSurat::where('type_surat', '=', $surat_[0])->where('id_surat', '=', $surat_[1]);
        if ($track_surat->count() >= 1) {
            $collection = array();
            foreach ($track_surat->get() as $key => $val) {

                $status_surat = false;
                if ($val->tgl_terima <> '0000-00-00') {
                    if ($val->tgl_kirim <> '0000-00-00') {
                        $status_surat = true;
                    } else {
                        $status_surat = false;
                    }
                } else {
                    $status_surat = false;
                }
                if ($val->tgl_kirim <> '0000-00-00') {
                    $collection[] = array(
                        'URUTAN' => $val->urutan,
                        'POSISI_SURAT' => $val->posisi_surat,
                        'TITLE' => $this->posisi[$val->posisi_surat],
                        'STATUS_SURAT' => $status_surat,
                        'TGL_TERIMA' => $val->tgl_terima,
                        'TGL_KIRIM' => $val->tgl_kirim,
                        'PENGIRIM' => $val->pengirim_pegawai?->nama ?? '-',
                        'PENERIMA' => $val->penerima_pegawai?->nama ?? '-',
                        'CATATAN' => $val->catatan
                    );
                }
            }
            $feedback = array(
                'is_error' => false,
                'data' => $collection,
                'msg' => 'Sukses'
            );
        } else {
            $feedback = array(
                'is_error' => true,
                'data' => array(),
                'msg' => 'Data tidak di temukan.'
            );
        }
        return response()->json($feedback, 200, array(), JSON_PRETTY_PRINT);
    }

    public function setujui(Request $request)
    {
        $waktu = Carbon::now();
        $user = Auth::user();
        $pegawai_user = DB::table('pegawai')->where('users_id', $user->id)->first();

        //explode untuk mendapatkan id surat & type surat;
        $surat_ = explode('-', $request->nomor);
        //$surat_[1] = id surat;
        //$surat_[0] = type surat;


        if ($user->level <> 'kepala_kantor') {

            $track_surat2 = TrackSurat::where('type_surat', '=', $surat_[0])->where('id_surat', '=', $surat_[1]);
            $track_surat2 = $track_surat2->where('urutan', '=', 2);
            $track_surat2->update([
                'tgl_kirim' => $waktu->toDateString(),
                // 'id_penerima' => $pegawai_user->id,
                'id_penerima' => $request->persetujuan_ke,
                'catatan' => $request->catatan
            ]);

            $track_surat3 = TrackSurat::where('type_surat', '=', $surat_[0])->where('id_surat', '=', $surat_[1]);
            $track_surat3 = $track_surat3->where('urutan', '=', 3);

            $track_surat3->update([
                'tgl_terima' => $waktu->toDateString(),
                // 'id_pengirim' => $pegawai_user->id
                'id_pengirim' => $request->persetujuan_ke,
            ]);
        } else {
            $track_surat3 = TrackSurat::where('type_surat', '=', $surat_[0])->where('id_surat', '=', $surat_[1]);
            $track_surat3 = $track_surat3->where('urutan', '=', 3);
            $track_surat3->update([
                'tgl_kirim' => $waktu->toDateString(),
                'id_penerima' => $pegawai_user->id,
                'catatan' => $request->catatan,
            ]);
        }

        $feedback = array(
            'is_error' => false,
            'data' => 'sukses',
            'msg' => 'Sukses!'
        );
        return response()->json($feedback);
    }
}