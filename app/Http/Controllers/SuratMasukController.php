<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\TrackSurat;
use App\Models\User;
use App\Models\SuratMasuk;
use App\Models\KlasifikasiSurat;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;

class SuratMasukController extends Controller
{
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

		$surat_masuk = SuratMasuk::get();
		return view('surat_masuk.index', compact('surat_masuk'));
	}

	public function create()
	{
		if (Auth::user()->level == 'user') {
			Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
			return redirect()->to('/');
		}
		$rak_penyimpanan = KlasifikasiSurat::all();
		return view('surat_masuk.create', compact('rak_penyimpanan'));
	}

	public function store(Request $request)
	{
		$this->validate($request, [
			'asal_surat_masuk' => 'required|string|max:255',
			'nomor_surat_masuk' => 'required|string|max:255',
			'tanggal_surat_masuk' => 'required|date|max:255',
			'lampiran_surat_masuk' => 'required|string|max:255',
			'perihal_surat_masuk' => 'required|string|max:255',
			'sifat_surat_masuk' => 'required',
			'keamanan_surat_masuk' => 'required',
			'rak_penyimpanan_id' => 'required'
		]);
		$user = Auth::user();
		$pegawai = Pegawai::where('users_id','=',$user->id)->first();

		if ($request->file('file_surat_masuk') == '') {
			$file_surat_masuk = NULL;
		} else {
			$file = $request->file('file_surat_masuk');
			$dt = Carbon::now();
			$acak = $file->getClientOriginalName();
			$fileName = rand(11111, 99999) . '-' . $dt->format('Y-m-d-H-i-s') . '.' . $acak;
			$request->file('file_surat_masuk')->move("files/surat_masuk", $fileName);
			$file_surat_masuk = $fileName;
		}

		$surat_masuk = SuratMasuk::create([
			'asal_surat_masuk' => $request->input('asal_surat_masuk'),
			'nomor_surat_masuk' => $request->input('nomor_surat_masuk'),
			'tanggal_surat_masuk' => $request->input('tanggal_surat_masuk'),
			'lampiran_surat_masuk' => $request->input('lampiran_surat_masuk'),
			'perihal_surat_masuk' => $request->input('perihal_surat_masuk'),
			'sifat_surat_masuk' => $request->input('sifat_surat_masuk'),
			'keamanan_surat_masuk' => $request->input('keamanan_surat_masuk'),
			'rak_penyimpanan_id' => $request->input('rak_penyimpanan_id'),
			'perekam_id' => $pegawai->id,
			'file_surat_masuk' => $file_surat_masuk,
		]);

		$this->init_track_surat($surat_masuk->id);

		Session::flash('message', 'Berhasil ditambahkan!');
		Session::flash('message_type', 'success');
		return redirect()->route('surat_masuk.index');
	}

	private function init_track_surat($id_surat)
	{
		$waktu = Carbon::now();
		TrackSurat::create([
			'type_surat' => 'SuratMasuk',
			'urutan' => 0,
			'id_surat' => $id_surat,
			'posisi_surat' => 'admin_arsip',
			'tgl_terima' => $waktu->toDateString(),
			'tgl_kirim' => $waktu->toDateString(),
		]);

		TrackSurat::create([
			'type_surat' => 'SuratMasuk',
			'urutan' => 1,
			'id_surat' => $id_surat,
			'posisi_surat' => 'kepala_tu',
			'tgl_terima' => $waktu->toDateString(),
		]);

		TrackSurat::create([
			'type_surat' => 'SuratMasuk',
			'urutan' => 2,
			'id_surat' => $id_surat,
			'posisi_surat' => 'kepala_kantor',
		]);

		TrackSurat::create([
			'type_surat' => 'SuratMasuk',
			'urutan' => 3,
			'id_surat' => $id_surat,
			'posisi_surat' => 'kepala_seksi',
		]);

		TrackSurat::create([
			'type_surat' => 'SuratMasuk',
			'urutan' => 4,
			'id_surat' => $id_surat,
			'posisi_surat' => 'staff_seksi',
		]);
	}

	public function show($id)
	{
		if ((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
			Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
			return redirect()->to('/');
		}

		$surat_masuk = SuratMasuk::findOrFail($id);

		return view('surat_masuk.show', compact('surat_masuk'));
	}

	public function edit($id)
	{
		if ((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
			Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
			return redirect()->to('/');
		}

		$surat_masuk = SuratMasuk::findOrFail($id);
		$rak_penyimpanan = KlasifikasiSurat::get();
		return view('surat_masuk.edit', compact('surat_masuk', 'rak_penyimpanan'));
	}

	public function update(Request $request, $id)
	{
		$surat_masuk = SuratMasuk::findOrFail($id);

		if ($request->file('file_surat_masuk')) {
			$file = $request->file('file_surat_masuk');
			$dt = Carbon::now();
			$acak = $file->getClientOriginalName();
			$fileName = rand(11111, 99999) . '-' . $dt->format('Y-m-d-H-i-s') . '.' . $acak;
			$request->file('file_surat_masuk')->move("files/surat_masuk", $fileName);
			$surat_masuk->file_surat_masuk = $fileName;
		}

		$surat_masuk->asal_surat_masuk = $request->input('asal_surat_masuk');
		$surat_masuk->nomor_surat_masuk = $request->input('nomor_surat_masuk');
		$surat_masuk->tanggal_surat_masuk = $request->input('tanggal_surat_masuk');
		$surat_masuk->lampiran_surat_masuk = $request->input('lampiran_surat_masuk');
		$surat_masuk->perihal_surat_masuk = $request->input('perihal_surat_masuk');
		$surat_masuk->sifat_surat_masuk = $request->input('sifat_surat_masuk');
		$surat_masuk->keamanan_surat_masuk = $request->input('keamanan_surat_masuk');
		$surat_masuk->rak_penyimpanan_id = $request->input('rak_penyimpanan_id');

		$surat_masuk->update();

		Session::flash('message', 'Berhasil diubah!');
		Session::flash('message_type', 'success');
		return redirect()->to('surat_masuk');
	}

	public function destroy($id)
	{
		if (Auth::user()->id != $id) {
			$surat_masuk = SuratMasuk::findOrFail($id);
			$surat_masuk->delete();
			Session::flash('message', 'Berhasil dihapus!');
			Session::flash('message_type', 'success');
		} else {
			Session::flash('message', 'Akun anda sendiri tidak bisa dihapus!');
			Session::flash('message_type', 'danger');
		}
		return redirect()->to('surat_masuk');
	}
}