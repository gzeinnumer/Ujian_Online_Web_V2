<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Peserta extends Authenticatable
{

    protected $table = 'peserta';
    public $timestamps = true;

    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    /**
     * Undocumented function
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ujians()
    {
        return $this->belongsToMany('App\Ujian', 'ujian_peserta', 'peserta_id', 'ujian_id')
            ->withPivot([
                'ruang_id', 'status', 'soal_ids',
                'nilai_pilihan', 'nilai_esay'
            ])
            ->using(UjianPeserta::class);
    }

    /**
     * Undocumented function
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function soals()
    {
        return $this->belongsToMany('App\Soal', 'jawaban', 'peserta_id', 'soal_id')
            ->withPivot(['jawaban', 'nilai']);
    }
}
