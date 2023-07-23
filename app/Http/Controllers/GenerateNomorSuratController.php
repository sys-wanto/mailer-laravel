<?php

namespace App\Http\Controllers;

use App\Models\NomorSurat;
use App\Models\NotaDinas;
use App\Models\Pegawai;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\SuratTugas;
use App\Models\TrackSurat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GenerateNomorSuratController extends Controller
{
	private $target_arsip_n_tu = array(
		'staff_tu',
		'admin_arsip'
	);

	public $pengamanan = array(
		'Biasa' => 'B',
		'Rahasia' => 'R',
		'Sangat Rahasia' => 'SR'
	);
	public function __construct()
	{
		$this->middleware('auth');
	}
	public function index()
	{
		$nota_dinas = DB::table('nota_dinas')->join('pegawai', 'nota_dinas.perekam_id', 'pegawai.id')->select(DB::raw("CONCAT('NotaDinas','-',nota_dinas.id) as id"), DB::raw("'NotaDinas' as jenis_surat"), DB::raw("perihal_nota_dinas as perihal"), DB::raw("file_nota_dinas as file"), 'nomor_surat', 'tanggal_nota_dinas AS tanggal_surat', 'pegawai.nama', 'nota_dinas.created_at AS created_at');
		$surat_tugas = DB::table('surat_tugas')->join('pegawai', 'surat_tugas.perekam_id', 'pegawai.id')->select(DB::raw("CONCAT('SuratTugas','-',surat_tugas.id) as id"), DB::raw("'SuratTugas' as jenis_surat"), DB::raw("perihal_surat_tugas as perihal"), DB::raw("file_surat_tugas as file"),'nomor_surat', 'tanggal_surat_tugas AS tanggal_surat', 'pegawai.nama', 'surat_tugas.created_at AS created_at');
		$surats_sql = DB::table('surat_keluar')->join('pegawai', 'surat_keluar.perekam_id', 'pegawai.id')->select(DB::raw("CONCAT('SuratKeluar','-',surat_keluar.id) as id"), DB::raw("'SuratKeluar' as jenis_surat"), DB::raw("perihal_surat_keluar as perihal"), DB::raw("file_surat_keluar as file"),'nomor_surat', 'tanggal_surat_keluar AS tanggal_surat', 'pegawai.nama', 'surat_keluar.created_at AS created_at')->union($surat_tugas)->union($nota_dinas)->toSql();
		$surats = DB::select("SELECT * FROM ({$surats_sql}) t ORDER BY nomor_surat REGEXP '^[^A-Za-z0-9]' DESC, created_at DESC");
		return view('generate_nomor_surat.index', compact('surats'));
	}

	public function proses(Request $request)
	{
		$nomor = explode('-', $request->nomor);
		$year = date('Y');
		$month = date('m');
		$feedback = array(
			'is_error' => true,
			'data' => null,
			'msg' => 'Error!'
		);
		$nomor_surat_count = NomorSurat::where('type_surat', '=', $nomor[0])->where('tahun_terbit', '=', $year)->where('bulan_terbit', '=', $month)->count();
		if ($nomor_surat_count == 0) {
			$urut = 1;
			NomorSurat::create([
				'type_surat' => $nomor[0],
				'tahun_terbit' => $year,
				'bulan_terbit' => $month,
				'nomor_urut' => $urut
			]);

			$return = $this->generate([
				'tahun_terbit' => $year,
				'bulan_terbit' => $month,
				'nomor_urut' => $urut
			], $request->nomor);
			if ($return) {
				$feedback = array(
					'is_error' => false,
					'data' => $return,
					'msg' => 'Sukses!'
				);
			}
		} else {
			$nomor_surat = NomorSurat::where('type_surat', '=', $nomor[0])->where('tahun_terbit', '=', $year)->where('bulan_terbit', '=', $month)->first();
			NomorSurat::where('type_surat', '=', $nomor[0])->where('tahun_terbit', $year)->where('bulan_terbit', $month)->update([
				'nomor_urut' => $nomor_surat->nomor_urut + 1
			]);

			$return = $this->generate([
				'tahun_terbit' => $year,
				'bulan_terbit' => $month,
				'nomor_urut' => $nomor_surat->nomor_urut + 1
			], $request->nomor);
			if ($return) {
				$feedback = array(
					'is_error' => false,
					'data' => $return,
					'msg' => 'Sukses!'
				);
			}
		}
		return response()->json($feedback);
	}

	private function init_track_surat($type_surat, $id_surat)
	{

		if ($type_surat == 'NotaDinas') {
			$surat = NotaDinas::where('id', '=', $id_surat);
		} else
			if ($type_surat == 'SuratKeluar') {
				$surat = SuratKeluar::where('id', '=', $id_surat);
			} else
				if ($type_surat == 'SuratMasuk') {
					$surat = SuratMasuk::where('id', '=', $id_surat);
				} else
					if ($type_surat == 'SuratTugas') {
						$surat = SuratTugas::where('id', '=', $id_surat);
					}
		$surat_data = $surat->first();
		$pegawai_perekam = Pegawai::where('id', '=', $surat_data->perekam_id)->first();
		$user_perekam = User::where('id', '=', $pegawai_perekam->users_id)->first();
		if (in_array($user_perekam->level, $this->target_arsip_n_tu)) {
			$target = 'kepala_tu';
		} else {
			$target = 'kepala_seksi';
		}


		$user = Auth::user();
		$pegawai = Pegawai::where('users_id', '=', $user->id)->first();

		$kepala = Pegawai::select('pegawai.id')->join('users', 'users.id', '=', 'pegawai.users_id')->where('pegawai.seksi_id', '=', $pegawai_perekam->seksi_id)->where('users.level', 'like', 'kepala%')->first();

		$waktu = Carbon::now();


		$track_surat0 = TrackSurat::where('type_surat', '=', $type_surat)->where('id_surat', '=', $id_surat)->where('urutan', '=', 0);

		$track_surat0->update([
			'id_penerima' => $pegawai->id,
		]);

		$track_surat1 = TrackSurat::where('type_surat', '=', $type_surat)->where('id_surat', '=', $id_surat)->where('urutan', '=', 1);

		$track_surat1->update([
			'tgl_terima' => $waktu->toDateString(),
			'tgl_kirim' => $waktu->toDateString(),
			'catatan' => 'Nomor di Generate',
			'id_pengirim' => $pegawai->id,
			'id_penerima' => $kepala->id,
		]);

		$track_surat1 = TrackSurat::where('type_surat', '=', $type_surat)->where('id_surat', '=', $id_surat)->where('urutan', '=', 2);

		$track_surat1->update([
			'tgl_terima' => $waktu->toDateString(),
			'posisi_surat' => $target,
			'id_pengirim' => $kepala->id,
		]);

	}


	private function generate($nomor, $id)
	{
		$param = explode('-', $id);
		if ($param[0] == 'SuratKeluar') {
			$SuratKeluar = SuratKeluar::where('id', '=', $param[1])->first();
			$pengamanan_surat = $this->pengamanan[$SuratKeluar->keamanan_surat_keluar];
			$klasifikasi = $SuratKeluar->klasifikasi_surat->kode_klasifikasi;
			$kode_seksi = $SuratKeluar->seksi->kode_seksi;
			$no_surat = $pengamanan_surat . '-' . $nomor['nomor_urut'] . '/' . $kode_seksi . '/' . $klasifikasi . '/' . $nomor['bulan_terbit'] . '/' . $nomor['tahun_terbit'];
			SuratKeluar::where('id', '=', $param[1])->update(['nomor_surat' => $no_surat]);
			$this->init_track_surat($param[0], $param[1]);
			return SuratKeluar::where('id', '=', $param[1])->first();
		} else
			if ($param[0] == 'SuratTugas') {
				$SuratTugas = SuratTugas::where('id', '=', $param[1])->first();
				$pengamanan_surat = $this->pengamanan[$SuratTugas->keamanan_surat_tugas];
				$klasifikasi = $SuratTugas->klasifikasi_surat->kode_klasifikasi;
				$kode_seksi = $SuratTugas->seksi->kode_seksi;
				$no_surat = $nomor['nomor_urut'] . '/' . $kode_seksi . '/' . $klasifikasi . '/' . $nomor['bulan_terbit'] . '/' . $nomor['tahun_terbit'];
				SuratTugas::where('id', '=', $param[1])->update(['nomor_surat' => $no_surat]);
				$this->init_track_surat($param[0], $param[1]);
				return SuratTugas::where('id', '=', $param[1])->first();
			} else
				if ($param[0] == 'NotaDinas') {
					$NotaDinas = NotaDinas::where('id', '=', $param[1])->first();
					$pengamanan_surat = $this->pengamanan[$NotaDinas->keamanan_nota_dinas];
					$klasifikasi = $NotaDinas->klasifikasi_surat->kode_klasifikasi;
					$kode_seksi = $NotaDinas->seksi->kode_seksi;
					$no_surat = $pengamanan_surat . '-' . $nomor['nomor_urut'] . '/' . $kode_seksi . '/' . $klasifikasi . '/' . $nomor['bulan_terbit'] . '/' . $nomor['tahun_terbit'];
					NotaDinas::where('id', '=', $param[1])->update(['nomor_surat' => $no_surat]);
					$this->init_track_surat($param[0], $param[1]);
					return NotaDinas::where('id', '=', $param[1])->first();
				} else {
					return false;
				}
	}
}