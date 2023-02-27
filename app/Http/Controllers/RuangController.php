<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ruang;

class RuangController extends Controller
{
    public function index(Request $request)
    {
        $ruangs = Ruang::all();

        $data = [
            'page_title' => 'Kelola Ruang',
            'ruangs' => $ruangs,
        ];

        return view('ruang.list', $data);
    }

    public function tambah(Request $request)
    {
        $ruang = new Ruang();
        $data = [
            'page_title' => 'Tambah Ruang',
            'ruang' => $ruang,
            'mode' => 'tambah',
        ];

        return view('ruang.form', $data);
    }

    public function create(Request $request)
    {
        $ruang = new Ruang();
        $this->save_ruang($request, $ruang);

        return redirect()->route('ruang')->with([
            'pesan' => 'Berhasil ditambah.'
        ]);
    }

    public function edit(Request $request, $id)
    {
        $ruang = Ruang::find($id);
        $data = [
            'page_title' => 'Edit Ruang',
            'ruang' => $ruang,
            'mode' => 'edit',
        ];

        return view('ruang.form', $data);
    }

    public function simpan(Request $request, $id)
    {
        $ruang = Ruang::find($id);
        $this->save_ruang($request, $ruang);

        return redirect()->route('ruang.edit', ['id' => $id])->with([
            'pesan' => 'Berhasil diedit.'
        ]);
    }

    public function save_ruang(Request $request, $ruang)
    {
        $ruang->nama = $request->get('nama');
        $ruang->save();
    }

    public function hapus(Request $request, $id)
    {
        $ruang = Ruang::find($id);
        $ruang->delete();

        return redirect()->route('ruang')->with([
            'pesan' => 'Berhasil dihapus.'
        ]);
    }
}
