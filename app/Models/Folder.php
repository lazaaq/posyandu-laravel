<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;
    protected $fillable = [
        'posyandu_id',
        'nama',
        'tanggal'
    ];
    protected $hidden = [];
    public function dataCollections() {
        return $this->hasMany(DataCollection::class);
    }
}
