<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ruang extends Model
{
    protected $table = 'ruang';
    protected $fillable = ['nama'];
    public $timestamps = true;

    use SoftDeletes;

    public function ikutan()
    {
        return $this->hasMany('App\UjianPeserta', 'ruang_id');
    }

    public function pesertas()
    {
        return $this->hasManyThrough(
            'App\Peserta',
            'App\UjianPeserta',
            'ruang_id',
            'id',
            'id',
            'peserta_id'
        );
    }
}
