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

class DataUtamaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getJenis($jenis_data_id){
        $data = JenisData::where('data_utama_id', $jenis_data_id)->get();
        return response()->json($data);
    }
 
    public function index()
    {
        if(Auth::user()->level == 'admin_user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $data_utama = DataUtama::get();
        return view('data_utama.index', compact('data_utama'));
    }

    public function create()
    {
        if(Auth::user()->level == 'admin_user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        return view('data_utama.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_data' => 'required|string|max:255'
        ]);

        DataUtama::create([
                'nama_data' => $request->get('nama_data'),
            ]);

        alert()->success('Berhasil.','Data telah ditambahkan!');

        return redirect()->route('data_utama.index');
    }

    public function show($id)
    {
        if((Auth::user()->level == 'admin_user') && (Auth::user()->id != $id)) {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
    }

        $data_utama = DataUtama::findOrFail($id);

        return view('data_utama.show', compact('data_utama'));
    }

    public function edit($id)
    {   
        if((Auth::user()->level == 'admin_user') && (Auth::user()->id != $id)) {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
    }

        $data_utama = DataUtama::findOrFail($id);
        return view('data_utama.edit', compact('data_utama'));
    }

    public function update(Request $request, $id)
    {
        DataUtama::find($id)->update([
            'nama_data' => $request->get('nama_data')
        ]);

        alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->route('data_utama.index');
    }

    public function destroy($id)
    {
        DataUtama::find($id)->delete();
        alert()->success('Berhasil.','Data telah dihapus!');
        return redirect()->route('data_utama.index');
    }
}
