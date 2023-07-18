<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataUtama;
use App\Models\JenisData;
use App\Models\KategoriData;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use Excel;
use RealRashid\SweetAlert\Facades\Alert;

class JenisDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getKategori($kategori_data_id){
        $datakategori = KategoriData::where('jenis_data_id', $kategori_data_id)->get();
        return response()->json($datakategori);
    }

    public function index()
    {
        if(Auth::user()->level == 'admin_user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $jenis_datas = JenisData::get();
        return view('jenis_data.index', compact('jenis_datas'));
    }

    public function create()
    {
        if(Auth::user()->level == 'admin_user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $data_utama = DataUtama::all();

        return view('jenis_data.create', compact('data_utama'));
    }

    public function store(Request $request)
    {
        $count = JenisData::where('id',$request->input('id'))->count();

        if($count>0){
            Session::flash('message', 'Already exist!');
            Session::flash('message_type', 'danger');
            return redirect()->to('jenis_data');
        }

        $this->validate($request, [
            'nama_jenis_data' => 'required|string|max:255',
        ]);

        $jenis_data = JenisData::create($request->all());
        $kategori_data = $request->kategori_data;
        foreach ($kategori_data as $key => $value) {
            KategoriData::create([
                'jenis_data_id'=>$jenis_data->id,
                'nama_kategori_data'=>$value,
            ]);
        }
        alert()->success('Berhasil.','Data telah ditambahkan!');
        return redirect()->route('jenis_data.index');

    }

    public function show($id)
    {
        if((Auth::user()->level == 'admin_user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $jenis_datas = JenisData::findOrFail($id);

        return view('jenis_data.show', compact('jenis_datas'));
    }

    public function edit($id)
    {
        if((Auth::user()->level == 'admin_user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $jenis_datas = JenisData::findOrFail($id);
        $data_utama = DataUtama::get();
        return view('jenis_data.edit', compact('jenis_datas', 'data_utama'));
    }

    public function update(Request $request, $id)
    {
        JenisData::find($id)->update($request->all());

        KategoriData::where('jenis_data_id',$id)->delete();
        $kategori_data = $request->kategori_data;
        foreach ($kategori_data as $key => $value) {
            KategoriData::create([
                'jenis_data_id'=>$id,
                'nama_kategori_data'=>$value,
            ]);
        }
        alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->to('jenis_data');
    }

    public function destroy($id)
    {
        JenisData::find($id)->delete();
        alert()->success('Berhasil.','Data telah dihapus!');
        return redirect()->route('jenis_data.index');
    }
}
