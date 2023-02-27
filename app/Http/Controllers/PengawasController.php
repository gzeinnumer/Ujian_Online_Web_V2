<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ujian;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Ruang;

class PengawasController extends Controller
{
    public function index(Request $request)
    {
        $ujians = Ujian::with(['dosen'])
            ->whereRaw('waktu_mulai <= now() and waktu_akhir >= now()')
            ->orderBy('nama', 'ASC')->get();

        $ruangs = Ruang::all();

        $data = [
            'page_title' => 'Pengawasan Ujian',
            'ujians' => $ujians,
            'ruangs' => $ruangs,
        ];

        return view('pengawasan.index', $data);
    }

    // public function lihat_peserta_old(Request $request, $id)
    // {
    //     $ujian = Ujian::with(['pesertas' => function (BelongsToMany $query) {
    //         $query->orderBy('no_induk', 'ASC');
    //     }])->findOrFail($id);

    //     $data = [
    //         'page_title' => 'Peserta Ujian : ' . $ujian->nama,
    //         'ujian' => $ujian,
    //         'label_ikut' => Config::get('constants.label_ikut_status'),
    //     ];

    //     return view('pengawasan.peserta', $data);
    // }

    public function lihat_peserta(Request $request, $ruang_id)
    {
        $ruang = Ruang::with([
            'ikutan' => function($query)
            {
                $query->whereHas('ujian', function($query)
                {
                    $query->whereRaw('waktu_mulai <= now() and waktu_akhir >= now()');
                });
            },
            'ikutan.peserta',
            'ikutan.ujian'
        ])->findOrFail($ruang_id);

        $data = [
            'page_title' => 'Peserta Ujian Ruang : ' . $ruang->nama,
            'ruang' => $ruang,
            'label_ikut' => Config::get('constants.label_ikut_status'),
        ];

        return view('pengawasan.peserta', $data);
    }

    public function ganti_status(Request $request, $ruang_id, $ujian_id, $peserta_id, $status)
    {
        if ($status) {
            $ujian = Ujian::findOrFail($ujian_id);
            $ujian->pesertas()->updateExistingPivot($peserta_id, [
                'status' => $status,
            ]);
        }

        return redirect()->route('pengawas.peserta', [$ruang_id]);
    }
}
