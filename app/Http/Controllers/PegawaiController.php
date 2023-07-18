<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seksi;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $pegawai = Pegawai::get();
        return view('pegawai.index', compact('pegawai'));
    }

    public function create()
    {
        if(Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $users = User::WhereNotExists(function($query) {
            $query->select(DB::raw(1))
            ->from('pegawai')
            ->whereRaw('pegawai.users_id = users.id');
        })->get();
        $seksi = Seksi::all();
        $jabatan = Jabatan::all();
        return view('pegawai.create', compact('users', 'seksi', 'jabatan'));
    }

    public function store(Request $request)
    {
        $count = Pegawai::where('nip',$request->input('nip'))->count();

        if($count>0){
            Session::flash('message', 'Already exist!');
            Session::flash('message_type', 'danger');
            return redirect()->to('pegawai');
        }

        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:20|unique:pegawai',
            'status_pegawai' => 'required',
            'users_id' => 'required',
            'seksi_id' => 'required',
            'jabatan_id' => 'required',
        ]);
        
        Pegawai::create($request->all());

        alert()->success('Berhasil.','Data telah ditambahkan!');
        return redirect()->route('pegawai.index');

    }

    public function show($id)
    {
        if((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $pegawai = Pegawai::findOrFail($id);

        return view('pegawai.show', compact('pegawai'));
    }

    public function edit($id)
    {   
        if((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $pegawai = Pegawai::findOrFail($id);
        $users = User::get();
        $seksi = Seksi::get();
        $jabatan = Jabatan::get();
        return view('pegawai.edit', compact('pegawai', 'users', 'seksi', 'jabatan'));
    }

    public function update(Request $request, $id)
    {
        Pegawai::find($id)->update($request->all());

        alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->to('pegawai');
    }

    public function destroy($id)
    {
        Pegawai::find($id)->delete();
        alert()->success('Berhasil.','Data telah dihapus!');
        return redirect()->route('pegawai.index');
    }
}
