<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    use HasFactory;
    protected $fillable = [
        'posyandu_id',
        'nama',
        'tgl_lahir',
        'jenis_kelamin',
        'nik',
        'kk',
        'bb_lahir',
        'tb_lahir',
        'anak_ke',
        'kia',
        'imd',
        'ibu_nama',
        'ibu_nik',
        'ibu_hp',
        'alamat_padukuhan',
        'alamat_rt',
        'alamat_rw',
        'active',
        'data'
    ];
    protected $hidden = [];
    public function data() {
        return $this->hasMany(DataCollection::class);
    }
    public function posyandu() {
        return $this->belongsTo(Posyandu::class);
    }
}
