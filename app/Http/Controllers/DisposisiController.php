<?php

namespace App\Http\Controllers;

use App\Models\NotaDinas;
use App\Models\Pegawai;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\SuratTugas;
use App\Models\TrackSurat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisposisiController extends Controller
{
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

    public $needle_staff = array(
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
        // $user = DB::table('pegawai')->join('users', 'users.id', '=', 'pegawai.users_id')->where('users_id', $user->id)->first();
        // $track_surats = TrackSurat::where('posisi_surat', '=', $user->level)->join('track_surat')->where('tgl_kirim', '=', '0000-00-00')->where('tgl_terima', '<>', '0000-00-00')->get();
        if (in_array($user->level, $this->needle_staff)) {
            $track_surats = TrackSurat::where('posisi_surat', '=', $user->level)->join('pegawai', 'pegawai.id', '=', 'track_surats.id_pengirim')->where('tgl_kirim', '=', '0000-00-00')->where('tgl_terima', '<>', '0000-00-00')->where('pegawai.seksi_id', '=', $user->seksi_id)->where('track_surats.id_pengirim', '=', $user->id)->get();
        } else {
            $track_surats = TrackSurat::where('posisi_surat', '=', $user->level)->join('pegawai', 'pegawai.id', '=', 'track_surats.id_pengirim')->where('tgl_kirim', '=', '0000-00-00')->where('tgl_terima', '<>', '0000-00-00')->where('pegawai.seksi_id', '=', $user->seksi_id)->get();
        }
        $collections = array();
        $check = array();
        foreach ($track_surats as $key => $track_surat) {
            if ($track_surat->type_surat == 'SuratMasuk') {
                $track_surat_lengkap = TrackSurat::where('id_surat', '=', $track_surat->id_surat)->where('type_surat','=','SuratMasuk')->get();
                $check[] = array_search($track_surat->posisi_surat, array_column($track_surat_lengkap->toArray(), 'posisi_surat'));
                $urutan_surat_sebelumnya = $track_surat->urutan - 1 >= 0 ? array_search($track_surat->urutan - 1, array_column($track_surat_lengkap->toArray(), 'urutan')) : 0;
                $surat_masuk = SuratMasuk::where('id', '=', $track_surat->id_surat)->first()->toArray();
                $surat_masuk['pengirim'] = $key == 0 ? 'Surat Masuk' : $track_surat->pengirim_pegawai?->nama ?? '-';
                $surat_masuk['tgl_terima'] = $track_surat->tgl_terima;
                $surat_masuk['tgl_kirim'] = $track_surat->tgl_kirim;
                $surat_masuk['posisi_surat'] = $track_surat->posisi_surat;
                $surat_urutan_mundur = TrackSurat::where('id_surat', '=', $track_surat->id_surat)->where('type_surat','=','SuratMasuk')->where('urutan', '=', $urutan_surat_sebelumnya)->first();
                $pengirim_asal = Pegawai::where('id', '=', $surat_urutan_mundur->id_pengirim)->first();
                $surat_masuk['asal'] = $pengirim_asal ? $pengirim_asal->nama : 'Surat Masuk';
                $surat_masuk['catatan'] = $surat_urutan_mundur->catatan;
                $surat_masuk['file'] = asset('files/surat_masuk/' . $surat_masuk['file_surat_masuk']);
                $collections[] = $surat_masuk;

            }
        }
        return view('disposisi.index', compact('collections'), compact('user'));
    }

    public function dispose(Request $request)
    {
        $dt = Carbon::now();
        $user = Auth::user();

        $pegawai_penerima = DB::table('pegawai')->where('id', $request->disposisi_ke)->first();
        $pegawai_penerima = DB::table('users')->where('id', '=', $pegawai_penerima->users_id)->first();

        if ($pegawai_penerima->level == 'kepala_tu') {
            $ganti_posisi_surat3 = TrackSurat::where('id_surat', '=', $request->nomor)->where('type_surat', '=', 'SuratMasuk');
            $ganti_posisi_surat3->where('urutan', '=', '3')->update([
                'posisi_surat' => 'kepala_tu'
            ]);
            $ganti_posisi_surat4 = TrackSurat::where('id_surat', '=', $request->nomor)->where('type_surat', '=', 'SuratMasuk');
            $ganti_posisi_surat4->where('urutan', '=', '4')->update([
                'posisi_surat' => 'staff_tu'
            ]);
        }

        $pegawai_user = DB::table('pegawai')->where('users_id', $user->id)->first();
        $track_surat = TrackSurat::where('posisi_surat', '=', $user->level)->where('id_surat', '=', $request->nomor)->where('type_surat', '=', 'SuratMasuk')->where('tgl_kirim', '=', '0000-00-00')->where('tgl_terima', '<>', '0000-00-00');
        $no_urut = $track_surat->first()->urutan;

        $track_surat->update([
            'tgl_kirim' => $dt->toDate()->format('Y-m-d'),
            'catatan' => $request->catatan ?? '',
            'id_pengirim' => $pegawai_user->id,
            'id_penerima' => $request->disposisi_ke,
        ]);
        $track_surat2 = TrackSurat::where('id_surat', '=', $request->nomor)->where('type_surat', '=', 'SuratMasuk')->where('tgl_kirim', '=', '0000-00-00')->where('tgl_terima', '=', '0000-00-00')->where('urutan', '=', $no_urut + 1);
        if ($track_surat2->count() >= 1) {
            $track_surat2->update([
                'id_pengirim' => $request->disposisi_ke,
                'tgl_terima' => $dt->toDate()->format('Y-m-d')
            ]);
        }
        if ($user->level == 'kepala_tu') {
            $track_surat3 = TrackSurat::where('id_surat', '=', $request->nomor)->where('type_surat', '=', 'SuratMasuk')->where('urutan', '=', '0');
            $track_surat3->update([
                'id_penerima' => $pegawai_user->id
            ]);
        }
        $feedback = array(
            'is_error' => false,
            'data' => 'sukses',
            'msg' => 'Sukses!'
        );
        return response()->json($feedback);
    }

    public function track($id_surat)
    {
        $exp = explode('-', $id_surat);
        $track_surat = TrackSurat::where('id_surat', '=', $exp[1])->where('type_surat', '=', $exp[0]);
        if ($track_surat->count() >= 1) {
            $collection = array();
            foreach ($track_surat->get() as $key => $val) {
                if ($val->type_surat == 'NotaDinas') {
                    $surat = NotaDinas::where('id', '=', $val->id_surat);
                } else
                    if ($val->type_surat == 'SuratKeluar') {
                        $surat = SuratKeluar::where('id', '=', $val->id_surat);
                    } else
                        if ($val->type_surat == 'SuratMasuk') {
                            $surat = SuratMasuk::where('id', '=', $val->id_surat);
                        } else
                            if ($val->type_surat == 'SuratTugas') {
                                $surat = SuratTugas::where('id', '=', $val->id_surat);
                            }
                $surat = $surat->first()->toArray();
                $perekam = DB::table('pegawai')->where('id', $surat['perekam_id'])->first();
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
                        'PENGIRIM' => $key == 0 ? $perekam->nama : $val->pengirim_pegawai?->nama ?? '-',
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

    public function done()
    {
        $user = Auth::user();
        $user = DB::table('pegawai')->select('users.level', 'pegawai.id', 'pegawai.seksi_id')->join('users', 'users.id', '=', 'pegawai.users_id')->where('pegawai.users_id', $user->id)->first();
        // $track_surats = TrackSurat::where('posisi_surat', '=', $user->level)->where('tgl_kirim', '<>', '0000-00-00')->where('tgl_terima', '<>', '0000-00-00')->get();
        // $track_surats = TrackSurat::where('posisi_surat', '=', $user->level)->join('pegawai','pegawai.id','=','track_surats.id_pengirim')->where('tgl_kirim', '<>', '0000-00-00')->where('tgl_terima', '<>', '0000-00-00')->where('pegawai.seksi_id','=',$user->seksi_id)->get();

        if (in_array($user->level, $this->needle_staff)) {
            $track_surats = TrackSurat::where('posisi_surat', '=', $user->level)->join('pegawai', 'pegawai.id', '=', 'track_surats.id_pengirim')->where('tgl_kirim', '<>', '0000-00-00')->where('tgl_terima', '<>', '0000-00-00')->where('pegawai.seksi_id', '=', $user->seksi_id)->where('track_surats.id_pengirim', '=', $user->id)->get();
        } else {
            $track_surats = TrackSurat::where('posisi_surat', '=', $user->level)->join('pegawai', 'pegawai.id', '=', 'track_surats.id_pengirim')->where('tgl_kirim', '<>', '0000-00-00')->where('tgl_terima', '<>', '0000-00-00')->where('pegawai.seksi_id', '=', $user->seksi_id)->get();
        }


        $track_surat_lengkap = TrackSurat::all()->toArray();
        $collections = array();
        foreach ($track_surats as $key => $track_surat) {
            if ($track_surat->type_surat == 'SuratMasuk') {
                $ids = array_search($track_surat->posisi_surat, array_column($track_surat_lengkap, 'posisi_surat'));
                $surat_masuk = SuratMasuk::where('id', '=', $track_surat->id_surat)->first()->toArray();
                $surat_masuk['tgl_terima'] = $track_surat->tgl_terima;
                $surat_masuk['tgl_kirim'] = $track_surat->tgl_kirim;
                $surat_masuk['posisi_surat'] = $track_surat->posisi_surat;
                $surat_masuk['asal'] = $key == 0 ? 'Surat Masuk' : $track_surat->pengirim_pegawai?->nama ?? '-';
                $surat_masuk['tujuan'] = $track_surat->penerima_pegawai?->nama ?? '-';
                $surat_masuk['catatan'] = $track_surat->catatan;
                $surat_masuk['file'] = asset('files/surat_masuk/' . $surat_masuk['file_surat_masuk']);
                $collections[] = $surat_masuk;
            }
        }
        return view('disposisi.done', compact('collections'));
    }
}