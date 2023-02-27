<?php

namespace App;

use Illuminate\Support\Facades\DB;


class UjianHelper
{
	public static function hitung_nilai(Peserta $peserta, $id_ujian)
	{
		$keikutsertaan = self::get_keikutsertaan($peserta, $id_ujian);
		$soal_pilihan = $peserta->soals()
			->wherePivotIn('soal_id', explode(',', $keikutsertaan->pivot->soal_ids))
			->where('type', SOAL_TYPE_PILIHAN)
			->get();

		$jumlah_soal_pilihan = min(
			$keikutsertaan->soals->where('type', SOAL_TYPE_PILIHAN)->count(),
			$keikutsertaan->jumlah_pilihan
		);

		$nilai_pilihan = 0;
		foreach ($soal_pilihan as $key => $soal) {
			if ($soal->benar == $soal->pivot->jawaban) {
				$nilai_pilihan++;
			}
		}

		$nilai_pilihan_akhir = $nilai_pilihan / $jumlah_soal_pilihan * 100;

		$peserta->ujians()->updateExistingPivot($id_ujian, [
			'nilai_pilihan' => $nilai_pilihan_akhir,
		]);
	}

	public static function get_keikutsertaan(Peserta $peserta, $id_ujian)
	{
		// DB::connection()->enableQueryLog();
		$keikutsertaan = $peserta->ujians()->with('dosen')->find($id_ujian);
		if ($keikutsertaan) {
			$selected_soals = $keikutsertaan
				->soals()
				->whereIn('id', explode(',', $keikutsertaan->pivot->soal_ids))
				->orderByRaw('FIND_IN_SET(id, ?) ASC', [$keikutsertaan->pivot->soal_ids])
				->get();
			$keikutsertaan->soal_pilihan = $selected_soals->where('type', SOAL_TYPE_PILIHAN)->flatten();
			$keikutsertaan->soal_esay = $selected_soals->where('type', SOAL_TYPE_ESAY)->flatten();
		}
		// return(DB::getQueryLog());

		return $keikutsertaan;
	}
}