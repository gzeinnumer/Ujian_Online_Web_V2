<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{

    protected $table = 'soal';
    public $timestamps = true;
    protected $hidden = [
        'benar',
        'created_at',
        'updated_at',
    ];

    public function pilihans()
    {
        return $this->hasMany('App\Pilihan', 'soal_id');
    }

}