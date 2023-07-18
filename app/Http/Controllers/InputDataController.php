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

class InputDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->level == 'admin_user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $input_datas = InputData::get();
        return view('input_data.index', compact('input_datas'));
    }

    public function create()
    {
        if (Auth::user()->level == 'admin_user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $data_utama = DataUtama::all();
        $jenis_data = JenisData::all();
        $kategori_data = KategoriData::all();
        $tahun_data = TahunData::all();
        return view('input_data.create', compact('data_utama', 'jenis_data', 'kategori_data', 'tahun_data'));
    }

    public function store(Request $request)
    {
        $count = InputData::where('id', $request->input('id'))->count();

        if ($count > 0) {
            Session::flash('message', 'Already exist!');
            Session::flash('message_type', 'danger');
            return redirect()->to('input_data');
        }

        $this->validate($request, [
            'tahun_data_id' => 'required',
            'data_utama_id' => 'required',
            'jenis_data_id' => 'required',
            'kategori_data_id' => 'required',
            'jumlah_data' => 'required',
        ]);
        $jml = $request->kategori_data_id;
        foreach ($jml as $key => $val) {
            $input = new InputData;
            $input->tahun_data_id = $request->tahun_data_id;
            $input->data_utama_id = $request->data_utama_id;
            $input->kategori_data_id = $request->kategori_data_id[$key];
            $input->jenis_data_id = $request->jenis_data_id;
            $input->jumlah_data = $request->jumlah_data[$key];
            $input->save();
        }

        alert()->success('Berhasil.', 'Data telah ditambahkan!');
        return redirect()->route('input_data.index');

    }

    public function show($id)
    {
        if ((Auth::user()->level == 'admin_user') && (Auth::user()->id != $id)) {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $input_datas = InputData::findOrFail($id);

        return view('input_data.show', compact('input_datas'));
    }

    public function edit($id)
    {
        if ((Auth::user()->level == 'admin_user') && (Auth::user()->id != $id)) {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $input_data = InputData::findOrFail($id);
        $data_utama = DataUtama::get();
        $jenis_data = JenisData::get();
        $kategori_data = KategoriData::get();
        $tahun_data = TahunData::get();
        return view('input_data.edit', compact('input_data', 'jenis_data', 'data_utama', 'kategori_data', 'tahun_data'));
    }

    public function update(Request $request, $id)
    {
        InputData::find($id)->update($request->all());

        alert()->success('Berhasil.', 'Data telah diubah!');
        return redirect()->to('input_data');
    }

    public function destroy($id)
    {
        InputData::find($id)->delete();
        alert()->success('Berhasil.', 'Data telah dihapus!');
        return redirect()->route('input_data.index');
    }
}