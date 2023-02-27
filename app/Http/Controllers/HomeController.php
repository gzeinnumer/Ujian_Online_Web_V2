<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'page_title' => 'Home',
            'status' => 'baik',
        ];
        return view('home', $data);
    }

    public function pengawas()
    {
        $data = [
            'page_title' => 'Pengawasan Ujian',
        ];
        return view('pengawas', $data);
    }

    public function upload_image(Request $request)
    {
        $user = $request->user();
        if ($gambar = $request->file('gambar')) {
            $doc_upload = $gambar->store('public/member_files/' . $user->id);

            return asset(Storage::url($doc_upload));
		}
    }

}
