<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataUtama;
use App\Models\JenisData;
use App\Models\KategoriData;
use App\Models\TahunData;
use App\Models\InputData;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use Excel;
use RealRashid\SweetAlert\Facades\Alert;

class CekDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getJenis($jenis_data_id){
        $data = JenisData::where('data_utama_id', $jenis_data_id)->get();
        return response()->json($data);
    }
     public function getKategori($kategori_data_id){
        $datakategori = KategoriData::where('jenis_data_id', $kategori_data_id)->get();
        return response()->json($datakategori);
    }
    public function index()
    {
        $cek_datas = InputData::get();
        $data_utama = DataUtama::all();
        $jenis_data = JenisData::all();
        $kategori_data = KategoriData::all();
        $tahun_data = TahunData::all();
        return view('cek_data.cekdata', compact('cek_datas', 'tahun_data', 'data_utama', 'jenis_data', 'kategori_data'));
    }

    public function create()
    {
        if(Auth::user()->level == 'admin_user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $data_utama = DataUtama::all();
        $jenis_data = JenisData::all();
        $kategori_data = KategoriData::all();
        $tahun_data = TahunData::all();
        return view('cek_data.create', compact('data_utama', 'jenis_data', 'kategori_data', 'tahun_data'));
    }

    public function store(Request $request)
    {
        $count = InputData::where('id',$request->input('id'))->count();

        if($count>0){
            Session::flash('message', 'Already exist!');
            Session::flash('message_type', 'danger');
            return redirect()->to('cek_data');
        }

        $this->validate($request, [
            'jumlah_data' => 'required|string|max:255',
        ]);

        InputData::create($request->all());

        alert()->success('Berhasil.','Data telah ditambahkan!');
        return redirect()->route('cek_data.index');

    }

    public function show($id)
    {
        if((Auth::user()->level == 'admin_user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $cek_datas = InputData::findOrFail($id);

        return view('cek_data.show', compact('cek_datas'));
    }

    public function edit($id)
    {   
        if((Auth::user()->level == 'admin_user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $cek_data = InputData::findOrFail($id);
        $data_utama = DataUtama::get();
        $jenis_data = JenisData::get();
        $kategori_data = KategoriData::get();
        $tahun_data = TahunData::get();
        return view('cek_data.edit', compact('cek_data', 'jenis_data', 'data_utama', 'kategori_data', 'tahun_data'));
    }

    public function update(Request $request, $id)
    {
        InputData::find($id)->update($request->all());

        alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->to('cek_data');
    }

    public function destroy($id)
    {
        InputData::find($id)->delete();
        alert()->success('Berhasil.','Data telah dihapus!');
        return redirect()->route('cek_data.index');
    }
}
