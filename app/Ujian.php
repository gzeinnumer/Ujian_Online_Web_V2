<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ujian extends Model
{

	protected $table = 'ujian';
	public $timestamps = true;

	protected $dates = [
		'waktu_mulai',
		'waktu_akhir',
	];

	public function soals()
	{
		return $this->hasMany('App\Soal', 'ujian_id');
	}

	public function pesertas()
	{
		return $this->belongsToMany('App\Peserta', 'ujian_peserta', 'ujian_id', 'peserta_id')
			->withPivot([
				'ruang_id', 'status', 'soal_ids',
				'nilai_pilihan', 'nilai_esay'
			])
			->using(UjianPeserta::class);
	}

	public function dosen()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	/** @var Carbon $waktu_akhir */
	// public $waktu_akhir;
	public function sisa_waktu()
	{
		$now = new Carbon();
		return $now < $this->waktu_akhir ? $this->waktu_akhir->diffInSeconds(new Carbon()) : 0;
	}
}
