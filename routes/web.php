<?php

use App\Http\Controllers\PersetujuanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DataUtamaController;
use App\Http\Controllers\JenisDataController;
use App\Http\Controllers\TahunDataController;
use App\Http\Controllers\InputDataController;
use App\Http\Controllers\LaporanDataController;
use App\Http\Controllers\CekDataController;
use App\Http\Controllers\SeksiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\LaporanUserController;
use App\Http\Controllers\KlasifikasiSuratController;
use App\Http\Controllers\KlasifikasiSurat_KepalaKantorController;
use App\Http\Controllers\KlasifikasiSurat_KepalaTUController;
use App\Http\Controllers\KlasifikasiSurat_KepalaSeksiController;
use App\Http\Controllers\KlasifikasiSurat_StaffSeksiController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratMasuk_KepalaKantorController;
use App\Http\Controllers\SuratMasuk_KepalaTUController;
use App\Http\Controllers\SuratMasuk_KepalaSeksiController;
use App\Http\Controllers\SuratMasuk_StaffSeksiController;
use App\Http\Controllers\Disposisi_KepalaKantorController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratKeluar_KepalaKantorController;
use App\Http\Controllers\SuratKeluar_KepalaTUController;
use App\Http\Controllers\SuratKeluar_KepalaSeksiController;
use App\Http\Controllers\SuratKeluar_StaffSeksiController;
use App\Http\Controllers\NotaDinasController;
use App\Http\Controllers\NotaDinas_KepalaKantorController;
use App\Http\Controllers\NotaDinas_KepalaTUController;
use App\Http\Controllers\NotaDinas_KepalaSeksiController;
use App\Http\Controllers\NotaDinas_StaffSeksiController;
use App\Http\Controllers\SuratTugasController;
use App\Http\Controllers\SuratTugas_KepalaKantorController;
use App\Http\Controllers\SuratTugas_KepalaTUController;
use App\Http\Controllers\SuratTugas_KepalaSeksiController;
use App\Http\Controllers\SuratTugas_StaffSeksiController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\GenerateNomorSuratController;
use App\Http\Controllers\LaporanSuratController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/', [HomeController::class, 'index']);

Route::get('/user/get/{staff?}', [UserController::class, 'get'])->name('user.get');
Route::resource('/user', UserController::class);

Route::resource('/seksi', SeksiController::class);

Route::get('getJabatan/{id}', [SeksiController::class, 'getJabatan']);

Route::resource('/pegawai', PegawaiController::class);

Route::get('/laporan_user/user', [LaporanUserController::class, 'user']);
Route::get('/laporan_user/user/pdf', [LaporanUserController::class, 'userPdf']);

Route::resource('/klasifikasi_surat', KlasifikasiSuratController::class);
Route::resource('/klasifikasi_surat_kepala_kantor', KlasifikasiSurat_KepalaKantorController::class);
Route::resource('/klasifikasi_surat_kepala_tu', KlasifikasiSurat_KepalaTUController::class);
Route::resource('/klasifikasi_surat_kepala_seksi', KlasifikasiSurat_KepalaSeksiController::class);
Route::resource('/klasifikasi_surat_staff_seksi', KlasifikasiSurat_StaffSeksiController::class);

Route::resource('/surat_masuk', SuratMasukController::class);
Route::resource('/surat_masuk_kepala_kantor', SuratMasuk_KepalaKantorController::class);
Route::resource('/surat_masuk_kepala_tu', SuratMasuk_KepalaTUController::class);
Route::resource('/surat_masuk_kepala_seksi', SuratMasuk_KepalaSeksiController::class);
Route::resource('/surat_masuk_staff_seksi', SuratMasuk_StaffSeksiController::class);

Route::resource('/disposisi_kepala_kantor', Disposisi_KepalaKantorController::class);
Route::get('/disposisi_kepala_kantor/index/home', [Disposisi_KepalaKantorController::class, 'home'])->name('disposisi_kepala_kantor.home');

Route::get('/persetujuan', [PersetujuanController::class, 'index'])->name('persetujuan.index');
Route::get('persetujuan/track/{id}', [PersetujuanController::class, 'track'])->name('persetujuan.track');
Route::get('/persetujuan/done', [PersetujuanController::class, 'done'])->name('persetujuan.done');
Route::post('/persetujuan/setujui', [PersetujuanController::class, 'setujui'])->name('persetujuan.setujui');
Route::get('/persetujuan/kepala', [PersetujuanController::class, 'kepala'])->name('persetujuan.kepala');

Route::get('/disposisi', [DisposisiController::class, 'index'])->name('disposisi.index');
Route::get('/track/{id}', [DisposisiController::class, 'track'])->name('disposisi.track');
Route::get('/disposisi/done', [DisposisiController::class, 'done'])->name('disposisi.done');
Route::post('/disposisi/dispose', [DisposisiController::class, 'dispose'])->name('disposisi.dispose');

Route::resource('/surat_keluar', SuratKeluarController::class);
Route::resource('/surat_keluar_kepala_kantor', SuratKeluar_KepalaKantorController::class);
Route::resource('/surat_keluar_kepala_tu', SuratKeluar_KepalaTUController::class);
Route::resource('/surat_keluar_kepala_seksi', SuratKeluar_KepalaSeksiController::class);
Route::resource('/surat_keluar_staff_seksi', SuratKeluar_StaffSeksiController::class);

Route::resource('/nota_dinas', NotaDinasController::class);
Route::resource('/nota_dinas_kepala_kantor', NotaDinas_KepalaKantorController::class);
Route::resource('/nota_dinas_kepala_tu', NotaDinas_KepalaTUController::class);
Route::resource('/nota_dinas_kepala_seksi', NotaDinas_KepalaSeksiController::class);
Route::resource('/nota_dinas_staff_seksi', NotaDinas_StaffSeksiController::class);

Route::resource('/surat_tugas', SuratTugasController::class);
Route::resource('/surat_tugas_kepala_kantor', SuratTugas_KepalaKantorController::class);
Route::resource('/surat_tugas_kepala_tu', SuratTugas_KepalaTUController::class);
Route::resource('/surat_tugas_kepala_seksi', SuratTugas_KepalaSeksiController::class);
Route::resource('/surat_tugas_staff_seksi', SuratTugas_StaffSeksiController::class);


Route::get('/generate_nomor_surat', [GenerateNomorSuratController::class, 'index']);
Route::post('/generate_nomor_surat/proses', [GenerateNomorSuratController::class, 'proses']);

Route::get('/laporan_surat/surat', [LaporanSuratController::class, 'surat']);
Route::get('/laporan_surat/surat/pdf', [LaporanSuratController::class, 'suratPdf']);



Route::resource('/data_utama', DataUtamaController::class);

Route::resource('/jenis_data', JenisDataController::class);

Route::get('getJenisCekData/{id}', [CekDataController::class, 'getJenis']);
Route::get('getKategoriCekData/{id}', [CekDataController::class, 'getKategori']);

Route::get('getJenis/{id}', [DataUtamaController::class, 'getJenis']);
Route::get('getKategori/{id}', [JenisDataController::class, 'getKategori']);

Route::resource('/tahun_data', TahunDataController::class);

Route::resource('/input_data', InputDataController::class);

Route::get('/laporan_data/data', [LaporanDataController::class, 'data']);
Route::get('/laporan_data/data/pdf', [LaporanDataController::class, 'dataPdf']);