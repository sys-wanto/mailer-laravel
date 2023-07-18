<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seksi;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use Excel;
use RealRashid\SweetAlert\Facades\Alert;

class SeksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getJabatan($jabatan_id){
        $datajabatan = Jabatan::where('seksi_id', $jabatan_id)->get();
        return response()->json($datajabatan);
    }

    public function index()
    {
        if(Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $seksi = Seksi::get();
        return view('seksi.index', compact('seksi'));
    }

    public function create()
    {
        if(Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        return view('seksi.create');
    }

    public function store(Request $request)
    {
        $count = Seksi::where('id',$request->input('id'))->count();

        if($count>0){
            Session::flash('message', 'Already exist!');
            Session::flash('message_type', 'danger');
            return redirect()->to('seksi');
        }

        $this->validate($request, [
            'kode_seksi' => 'required|string|max:255',
            'nama_seksi' => 'required|string|max:255',
        ]);

        $seksi = Seksi::create($request->all());
        $jabatan = $request->jabatan;
        foreach ($jabatan as $key => $value) {
            Jabatan::create([
                'seksi_id'=>$seksi->id,
                'nama_jabatan'=>$value,
            ]);
        }
        alert()->success('Berhasil.','Data telah ditambahkan!');
        return redirect()->route('seksi.index');

    }

    public function show($id)
    {
        if((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $seksi = Seksi::findOrFail($id);

        return view('seksi.show', compact('seksi'));
    }

    public function edit($id)
    {
        if((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $seksi = Seksi::findOrFail($id);
        return view('seksi.edit', compact('seksi'));
    }

    public function update(Request $request, $id)
    {
        Seksi::find($id)->update($request->all());

        Jabatan::where('seksi_id',$id)->delete();
        $jabatan = $request->jabatan;
        foreach ($jabatan as $key => $value) {
            Jabatan::create([
                'seksi_id'=>$id,
                'nama_jabatan'=>$value,
            ]);
        }
        alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->to('seksi');
    }

    public function destroy($id)
    {
        Seksi::find($id)->delete();
        alert()->success('Berhasil.','Data telah dihapus!');
        return redirect()->route('seksi.index');
    }
}
