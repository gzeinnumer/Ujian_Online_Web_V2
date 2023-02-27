<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UjianPeserta extends Pivot
{

    protected $table = 'ujian_peserta';
    public $timestamps = true;

    public function ruang()
    {
        return $this->belongsTo('App\Ruang', 'ruang_id');
    }

    public function peserta()
    {
        return $this->belongsTo('App\Peserta', 'peserta_id');
    }

    public function ujian()
    {
        return $this->belongsTo('App\Ujian', 'ujian_id');
    }
}
