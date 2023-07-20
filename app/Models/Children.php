<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'tgl_lahir',
        'jenis_kelamin',
        'nik',
        'kk',
        'bb_lahir',
        'tb_lahir',
        'ibu_nama',
        'ibu_nik',
        'ibu_hp',
        'alamat_padukuhan',
        'alamat_rt',
        'alamat_rw',
        'active'
    ];
}
