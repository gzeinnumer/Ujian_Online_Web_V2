<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Peserta;
use App\Ujian;
use App\Jawaban;
use App\UjianPeserta;
use Illuminate\Support\Facades\DB;
use App\UjianHelper;
use Illuminate\Http\Response;
use App\Ruang;

class PesertaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pesertas = Peserta::all();
        $data = [
            'page_title' => 'Kelola Peserta',
            'pesertas' => $pesertas,
        ];
        return view('peserta', $data);
    }

    public function tambah(Request $request)
    {
        $peserta = new Peserta();
        $data = [
            'page_title' => 'Tambah Peserta',
            'peserta' => $peserta,
            'mode' => 'tambah',
        ];

        return view('peserta-form', $data);
    }

    public function create(Request $request)
    {
        $user = Auth::user();

        $peserta = new Peserta();
        $peserta->password = '';
        $this->save_peserta($request, $peserta);

        return redirect()->route('peserta')->with([
            'pesan' => 'Berhasil ditambah.'
        ]);
    }

    public function edit(Request $request, $id)
    {
        $peserta = Peserta::find($id);
        $data = [
            'page_title' => 'Edit Peserta',
            'peserta' => $peserta,
            'mode' => 'edit',
        ];

        return view('peserta-form', $data);
    }

    public function simpan(Request $request, $id)
    {
        $peserta = Peserta::find($id);
        $this->save_peserta($request, $peserta);

        return redirect()->route('peserta.edit', ['id' => $id])->with([
            'pesan' => 'Berhasil diedit.'
        ]);
    }

    public function save_peserta(Request $request, $peserta)
    {
        $user = Auth::user();
        $peserta->nama = $request->get('nama');
        $peserta->no_induk = $request->get('no_induk');
        $peserta->email = $request->get('email');
        if ($request->get('password')) {
            $peserta->password = bcrypt($request->get('password'));
        }
        $peserta->phone = $request->get('phone');
        $peserta->save();
    }

    public function hapus_peserta(Request $request, $id)
    {
        $peserta = Peserta::find($id);
        $peserta->delete();

        return redirect()->route('peserta')->with([
            'pesan' => 'Berhasil dihapus.'
        ]);
    }




    public function api_login(Request $request)
    {
        $result = [
            'success' => false,
            'token' => '',
            'peserta' => false,
        ];

        $no_induk = $request->get('no_induk');
        $password = $request->get('password');

        $valid = Auth::guard('web-peserta')
            ->validate($request->only('no_induk', 'password'));

        if ($valid) {
            $result['success'] = true;
            $result['token'] = str_random(50);

            $peserta = Peserta::where('no_induk', $no_induk)->first();
            $peserta->api_token = $result['token'];
            $peserta->save();

            $result['peserta'] = $peserta;
        }

        return $result;
    }

    public function ujians(Request $request)
    {
        $ujians = Ujian::with(['dosen'])
            ->whereRaw('waktu_mulai <= now() and waktu_akhir >= now()')
            ->orderBy('nama', 'ASC')->get();
        return $ujians;
    }

    public function ujian(Request $request, $id)
    {
        $ujians = Ujian::with('soals')->findOrFail($id);
        return $ujians;
    }

    public function ikuti_ujian(Request $request, $id)
    {
        /** @var Ujian $keikutsertaan */
        /** @var Peserta $peserta */

        $ujian = Ujian::with('soals')->findOrFail($id);
        $peserta = $request->user();
        $keikutsertaan = UjianHelper::get_keikutsertaan($peserta, $ujian->id);
        if (!$keikutsertaan) {
            $soal_pilihan = $ujian->soals->where('type', SOAL_TYPE_PILIHAN);
            $soal_esay = $ujian->soals->where('type', SOAL_TYPE_ESAY);

            // merandom soal pilihan
            $soal_pilihan_ids = $soal_pilihan
                ->shuffle()
                ->slice(0, $ujian->jumlah_pilihan)
                ->pluck('id')
                ->toArray();

            // merandom soal esay
            $soal_esay_ids = $soal_esay
                ->shuffle()
                ->slice(0, $ujian->jumlah_esay)
                ->pluck('id')
                ->toArray();

            $soal_ids = array_merge($soal_pilihan_ids, $soal_esay_ids);

            $peserta->ujians()->attach($ujian, [
                'status' => IKUT_STATUS_PENDING,
                'soal_ids' => implode(',', $soal_ids),
                'ruang_id' => $request->get('ruang_id'),
            ]);
            $keikutsertaan = UjianHelper::get_keikutsertaan($peserta, $ujian->id);
        }

        $keikutsertaan->sisa_waktu = $keikutsertaan->sisa_waktu();

        if ($keikutsertaan->pivot->status == IKUT_STATUS_KICKED) {
            return new Response('Anda telah dikeluarkan dari ujian ini.', 403);
        }

        if ($keikutsertaan->pivot->status == IKUT_STATUS_DONE) {
            return new Response('Anda sudah mengikuti ujian ini.', 403);
        }

        if ($keikutsertaan->sisa_waktu < 1) {
            return new Response('Waktu untuk ujian ini telah berakhir.', 403);
        }

        // update ruang jika tidak ada masalah
        $peserta->ujians()->updateExistingPivot($ujian->id, [
            'ruang_id' => $request->get('ruang_id'),
        ]);

        return new Response($keikutsertaan, 200);
    }

    public function simpan_jawaban(Request $request, $id_ujian)
    {
        $result = [
            'success' => false,
        ];

        /** @var Peserta $peserta */
        $peserta = $request->user();

        /** @var Ujian $ujian */
        $ujian = $peserta->ujians()->findOrFail($id_ujian);

        if ($ujian->pivot->status == IKUT_STATUS_KICKED) {
            return new Response('Anda telah dikeluarkan dari ujian ini. Jawaban anda tidak akan tercatat.', 403);
        }

        $jawabans_raw = json_decode($request->get('jawabans'), true) ?? [];

        $jawabans = [];
        foreach ($jawabans_raw as $key => $value) {
            $jawabans[$key] = [
                'jawaban' => $value,
            ];
        }

        $peserta->soals()->syncWithoutDetaching($jawabans);

        UjianHelper::hitung_nilai($peserta, $id_ujian);

        $peserta->ujians()->updateExistingPivot($id_ujian, [
            'status' => IKUT_STATUS_DONE,
        ]);

        return $result;
    }

    public function daftar_nilai(Request $request)
    {
        $ujians = $request->user()
            ->ujians()
            ->with('dosen')
            ->wherePivot('status', IKUT_STATUS_DONE)
            ->orderBy('waktu_akhir', 'desc')
            ->get();
        return $ujians;
    }

    public function cek_ikut_status(Request $request, $ujian_id)
    {
        $peserta = $request->user();
        $ujian = $peserta->ujians()->findOrFail($ujian_id);

        return $ujian->pivot;
    }

    public function ruangs(Request $request)
    {
        $ruangs = Ruang::all();

        return $ruangs;
    }
}
