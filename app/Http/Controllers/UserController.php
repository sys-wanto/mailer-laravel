<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
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

        $datas = User::get();
        return view('auth.user', compact('datas'));
    }

    public function create()
    {
        if (Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $count = User::where('username', $request->input('username'))->count();

        if ($count > 0) {
            Session::flash('message', 'Already exist!');
            Session::flash('message_type', 'danger');
            return redirect()->to('user');
        }

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:20|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);


        if ($request->file('gambar') == '') {
            $gambar = NULL;
        } else {
            $file = $request->file('gambar');
            $dt = Carbon::now();
            $acak = $file->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '-' . $dt->format('Y-m-d-H-i-s') . '.' . $acak;
            $request->file('gambar')->move("images/user", $fileName);
            $gambar = $fileName;
        }

        User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'level' => $request->input('level'),
            'password' => bcrypt(($request->input('password'))),
            'gambar' => $gambar
        ]);

        Session::flash('message', 'Berhasil ditambahkan!');
        Session::flash('message_type', 'success');
        return redirect()->route('user.index');

    }

    public function show($id)
    {
        if ((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $data = User::findOrFail($id);

        return view('auth.show', compact('data'));
    }

    public function edit($id)
    {
        if ((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $data = User::findOrFail($id);

        return view('auth.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $user_data = User::findOrFail($id);

        if ($request->file('gambar')) {
            $file = $request->file('gambar');
            $dt = Carbon::now();
            $acak = $file->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '-' . $dt->format('Y-m-d-H-i-s') . '.' . $acak;
            $request->file('gambar')->move("images/user", $fileName);
            $user_data->gambar = $fileName;
        }

        $user_data->name = $request->input('name');
        $user_data->email = $request->input('email');
        if ($request->input('password')) {
            $user_data->level = $request->input('level');
        }

        if ($request->input('password')) {
            $user_data->password = bcrypt(($request->input('password')));

        }

        $user_data->update();

        Session::flash('message', 'Berhasil diubah!');
        Session::flash('message_type', 'success');
        return redirect()->to('user');
    }

    public function destroy($id)
    {
        if (Auth::user()->id != $id) {
            $user_data = User::findOrFail($id);
            $user_data->delete();
            Session::flash('message', 'Berhasil dihapus!');
            Session::flash('message_type', 'success');
        } else {
            Session::flash('message', 'Akun anda sendiri tidak bisa dihapus!');
            Session::flash('message_type', 'danger');
        }
        return redirect()->to('user');
    }

    public function get($staff = null)
    {
        $user = Auth::user();
        $pegawai_user = DB::table('pegawai')->where('users_id', $user->id)->first();
        $user_data = DB::table('users')->select('pegawai.id', 'pegawai.nama AS name')->join('pegawai', 'users.id', '=', 'pegawai.users_id');
        if ($user->level == 'admin_arsip') {
            $user_data->where('users.level', '=', 'kepala_tu');
        } else
            if ($user->level == 'kepala_tu') {
                if ($staff) {
                    $user_data->where('users.level', '=', 'kepala_kantor');
                } else {
                    $user_data->where('users.level', '=', 'staff_tu');
                }
            } else
                if ($user->level == 'kepala_kantor') {
                    $user_data->whereIn('users.level', array('kepala_seksi', 'kepala_tu'));
                } else
                    if ($user->level == 'kepala_seksi') {
                        $user_data->where('users.level', '=', 'staff_seksi')->where('pegawai.seksi_id', '=', $pegawai_user->seksi_id);
                    }
                    // dd($user_data);
        if ($user_data->count() >= 1) {
            $feedback = array(
                'is_error' => false,
                'data' => $user_data->get(),
                'msg' => 'sukses'
            );
        } else {
            $feedback = array(
                'is_error' => true,
                'data' => array('TIDAK ADA'),
                'msg' => 'sukses'
            );
        }
        return response()->json($feedback, 200, array(), JSON_PRETTY_PRINT);
    }
}