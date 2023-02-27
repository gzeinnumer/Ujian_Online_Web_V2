<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Http\Middleware\CekAdmin;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware(CekAdmin::class);
    }

    public function index()
    {
        $user = Auth::user();
        $users = User::all();
        $data = [
            'page_title' => 'Kelola User',
            'users' => $users,
        ];
        return view('user', $data);
    }

    public function tambah(Request $request)
    {
        $user = new User();
        $data = [
            'page_title' => 'Tambah User',
            'user' => $user,
            'mode' => 'tambah',
        ];

        return view('user-form', $data);
    }

    public function create(Request $request)
    {
        // $user = Auth::user();

        $user = new User();
        $user->password = '';
        $this->save_user($request, $user);

        return redirect()->route('user')->with([
            'pesan' => 'Berhasil ditambah.'
        ]);
    }

    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        $data = [
            'page_title' => 'Edit User',
            'user' => $user,
            'mode' => 'edit',
        ];

        return view('user-form', $data);
    }

    public function simpan(Request $request, $id)
    {
        $user = User::find($id);
        $this->save_user($request, $user);

        if(Auth::user()->id == $id)
        {
            return redirect()->route('profil')->with([
                'pesan' => 'Profil Berhasil Diupdate.']);
        }
        else
        {
            return redirect()->route('user.edit', ['id' => $id])->with([
                'pesan' => 'Berhasil diedit.'
            ]);
        }
    }

    public function profil(Request $request)
    {
        $user = Auth::user();
        $data = [
            'page_title' => 'Edit User',
            'user' => $user,
            'mode' => 'edit',
        ];

        return view('user-form', $data);

    }

    public function save_user(Request $request, $user)
    {
        // $user = Auth::user();
        $user->name = $request->get('nama');
        $user->email = $request->get('email');
        if ($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }
        $user->save();
    }

    public function hapus_user(Request $request, $id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('user')->with([
            'pesan' => 'Berhasil dihapus.'
        ]);

    }

}
