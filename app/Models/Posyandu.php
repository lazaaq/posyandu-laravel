<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'alamat_padukuhan'
    ];
    public function posyandu() {
        return $this->belongsTo(User::class);
    }
}
