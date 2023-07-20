<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataCollection extends Model
{
    use HasFactory;
    protected $fillable = [
        'bb',
        'tb',
        'lika',
        'lile',
    ];
    public function posyandu() {
        return $this->belongsTo(Posyandu::class);
    }
    public function children() {
        return $this->belongsTo(Children::class);
    }
}
