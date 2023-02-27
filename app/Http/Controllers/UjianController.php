<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ujian;
use Illuminate\Support\Facades\Auth;
use App\Soal;
use App\Pilihan;
use Carbon\Carbon;
use App\UjianHelper;
use App\Peserta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Helpers\ExcelReader;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\ExcelWriter;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class UjianController extends Controller
{
	public function index()
	{
		$user = Auth::user();
		$ujians = $user
			->ujians()
			->orderBy('created_at', 'desc')
			->get();

		$data = [
			'page_title' => 'Kelola Ujian',
			'ujians' => $ujians,
		];

		return view('ujian', $data);
	}

	public function tambah(Request $request)
	{
		$ujian = new Ujian();
		$ujian->waktu_mulai = Carbon::now();
		$ujian->waktu_mulai = Carbon::now();
		$ujian->waktu_akhir = Carbon::now();

		$data = [
			'page_title' => 'Tambah Ujian',
			'ujian' => $ujian,
			'mode' => 'tambah',
		];

		return view('ujian-form', $data);
	}

	public function create(Request $request)
	{
		$user = Auth::user();

		$ujian = new Ujian();
		$this->save_ujian($request, $ujian);

		return redirect()->route('ujian')->with([
			'pesan' => 'Berhasil ditambah.'
		]);
	}

	public function edit(Request $request, $id)
	{
		$ujian = Ujian::find($id);
		$data = [
			'page_title' => 'Edit Ujian',
			'ujian' => $ujian,
			'mode' => 'edit',
		];

		return view('ujian-form', $data);
	}

	public function simpan(Request $request, $id)
	{
		$ujian = Ujian::find($id);
		$this->save_ujian($request, $ujian);

		return redirect()->route('ujian.edit', ['id' => $id])->with([
			'pesan' => 'Berhasil diedit.'
		]);
	}

	public function hapus_ujian(Request $request, $id)
	{
		$ujian = Ujian::find($id);
		$ujian->delete();

		return redirect()->route('ujian')->with([
			'pesan' => 'Berhasil dihapus.'
		]);
	}

	public function save_ujian(Request $request, $ujian)
	{
		$tanggal = Carbon::parse($request->get('tanggal'));
		$waktu_mulai = Carbon::parse($tanggal->format('Y-m-d ') . $request->get('waktu_mulai'));
		$waktu_akhir = Carbon::parse($tanggal->format('Y-m-d ') . $request->get('waktu_akhir'));

		$user = Auth::user();
		$ujian->nama = $request->get('nama');
		$ujian->deskripsi = $request->get('deskripsi');
		$ujian->waktu_mulai = $waktu_mulai;
		$ujian->waktu_akhir = $waktu_akhir;
		$ujian->user_id = $user->id;
		$ujian->jumlah_pilihan = $request->jumlah_pilihan ?: 0;
		$ujian->jumlah_esay = $request->jumlah_esay ?: 0;
		$ujian->save();

		/* proses soal */
		$soal_lama_ids = $ujian->soals->pluck('id')->toArray();
		$soal_pilihan = [];
		$soal_esay = [];
		try {
			$soal_pilihan = json_decode($request->get('soal_pilihan'));
			$soal_esay = json_decode($request->get('soal_esay'));
		} catch (\Throwable $th) { }

		$all_soal = array_merge($soal_pilihan, $soal_esay);
		foreach ($all_soal as $key => $item) {
			if ($item->id) {
				$soal = Soal::find($item->id) ?: new Soal();

				/* exclude soal yang masih dipakai dari soal lama */
				$index_lama = array_search($item->id, $soal_lama_ids);
				if ($index_lama !== false) {
					unset($soal_lama_ids[$index_lama]);
				}
			} else {
				$soal = new Soal();
			}

			$soal->pertanyaan = $item->pertanyaan;
			$soal->type = $item->type;

			if ($item->type == 'pilihan') {
				$soal->a = $item->a;
				$soal->b = $item->b;
				$soal->c = $item->c;
				$soal->d = $item->d;
				$soal->e = $item->e;
				$soal->benar = $item->benar;
			}
			$soal->ujian_id = $ujian->id;
			$soal->save();
		}

		/* hapus soal lama */
		Soal::destroy($soal_lama_ids);

		$ujian->save();
	}

	public function lihat_nilai(Request $request, $id)
	{
		$ujian = Ujian::with(['pesertas' => function (BelongsToMany $query) {
			$query->wherePivot('status', IKUT_STATUS_DONE);
		}])->findOrFail($id);

		$data = [
			'page_title' => 'Daftar Nilai Ujian : ' . $ujian->nama,
			'ujian' => $ujian,
		];

		return view('nilai.list', $data);
	}

	public function koreksi_esay(Request $request, $id_ujian, $id_peserta)
	{
		$peserta = Peserta::findOrFail($id_peserta);
		$keikutsertaan = UjianHelper::get_keikutsertaan($peserta, $id_ujian);

		$soal_esay = $peserta->soals()
			->wherePivotIn('soal_id', explode(',', $keikutsertaan->pivot->soal_ids))
			->where('type', SOAL_TYPE_ESAY)
			->get();

		$data = [
			'page_title' => 'Koreksi Esay',
			'peserta' => $peserta,
			'keikutsertaan' => $keikutsertaan,
			'soal_esay' => $soal_esay,
		];
		return view('nilai.koreksi', $data);
	}

	public function simpan_nilai(Request $request, $id_ujian, $id_peserta)
	{
		$nilais = $request->get('nilai', []);

		/** @var Peserta $peserta */
		$peserta = Peserta::findOrFail($id_peserta);

		/** @var Ujian $keikutsertaan */
		$keikutsertaan = UjianHelper::get_keikutsertaan($peserta, $id_ujian);

		$soal_esay = $peserta->soals()
			->wherePivotIn('soal_id', explode(',', $keikutsertaan->pivot->soal_ids))
			->where('type', SOAL_TYPE_ESAY)
			->get();

		foreach ($soal_esay as $key => $soal) {
			$nilai = $nilais[$soal->id] ?? 0;
			$peserta->soals()->updateExistingPivot($soal->id, [
				'nilai' => $nilai,
			]);
		}

		$jumlah_soal_esay = min(
			$keikutsertaan->soals->where('type', SOAL_TYPE_ESAY)->count(),
			$keikutsertaan->jumlah_esay
		);

		$nilai_esay_akhir = array_sum($nilais) / $jumlah_soal_esay;
		$peserta->ujians()->updateExistingPivot($id_ujian, [
			'nilai_esay' => $nilai_esay_akhir,
		]);

		return redirect()->route('ujian.nilai', [$id_ujian])->with([
			'pesan' => 'Nilai berhasil disimpan.'
		]);
	}

	public function import_soal(Request $request)
	{
		$result = [
			'success' => true,
			'message' => '',
		];

		$user_id = $request->user()->id;
		$request->file('xlsx')->storeAs('upload/' . $user_id, 'soals.xlsx');
		$soals = Storage::disk('local')->path('upload/' . $user_id . '/soals.xlsx');

		try {
			$excel = new ExcelReader();
			$excel->read_xlsx($soals);
		} catch (\Exception $e) {
			$result['success'] = false;
			$result['message'] = 'File tidak dapat dibaca.';

			return $result;
		}

		$row_count = $excel->get_row_count(0);

		$soals = [];
		for ($i = 2; $i <= $row_count; $i++) {
			$soal = [
				'type' => $excel->get_cell_value(0, 'A' . $i),
				'pertanyaan' => $excel->get_cell_value(0, 'B' . $i),
				'a' => $excel->get_cell_value(0, 'C' . $i),
				'b' => $excel->get_cell_value(0, 'D' . $i),
				'c' => $excel->get_cell_value(0, 'E' . $i),
				'd' => $excel->get_cell_value(0, 'F' . $i),
				'e' => $excel->get_cell_value(0, 'G' . $i),
				'benar' => strtolower($excel->get_cell_value(0, 'H' . $i)),
			];

			if (
				$soal['pertanyaan'] &&
				in_array($soal['type'], [SOAL_TYPE_PILIHAN, SOAL_TYPE_ESAY])
			) {
				$soals[] = $soal;
			}
		}

		if(count($soals) < 1)
		{
			$result['success'] = false;
			$result['message'] = 'Soal tidak ditemukan, periksa kembali file excel anda.';
		}

		$result['soals'] = $soals;

		return $result;
	}

	public function export_nilai(Request $request, $ujian_id)
	{
		$ujian = Ujian::with(['pesertas' => function (BelongsToMany $query) {
			$query->wherePivot('status', IKUT_STATUS_DONE);
		}])->findOrFail($ujian_id);

		$rows = [];
		foreach ($ujian->pesertas as $key => $peserta) {
			$rows[] = [
				'A' => $peserta->no_induk,
				'B' => $peserta->nama,
				'C' => $peserta->pivot->nilai_pilihan,
				'D' => $peserta->pivot->nilai_esay,
			];
		}

		$args = [
			'header' => [
				'A' => 'NIM',
				'B' => 'Nama',
				'C' => 'Nilai Pilihan Ganda',
				'D' => 'Nilai Esay',
			],
			'header_style' => [
				'font' => [
					'bold' => true,
					'color' => [
						'rgb' => 'ffffff'
					]
				],
				'alignment' => [
					'horizontal' => Alignment::HORIZONTAL_CENTER,
					'vertical' => Alignment::VERTICAL_CENTER,
					'wrapText' => true,
				],
				'fill' => [
					'fillType' => Fill::FILL_SOLID,
					'startColor' => [
						'rgb' => '80a6b3',
					],
				],
			],
			'column_width' => [
				'A' => 12,
				'B' => 30,
				'C' => 20,
				'D' => 20,
			],
			'rows' => $rows,
			'rows_style' => [
				'A' => [
					'alignment' => [
						'horizontal' => Alignment::HORIZONTAL_CENTER,
					],
				],
				'B' => [
					'alignment' => [
						'wrapText' => true,
					],
				],
			],
			'rows_height' => [
				1 => 30,
			],
			'sheet_title' => $ujian->nama,
		];

		$writer = new ExcelWriter();
		$writer->write_excel(
			$args,
			str_slug('nilai-' . $ujian->nama . date(' d-m-Y')) . '.xlsx'
		);
	}
}
