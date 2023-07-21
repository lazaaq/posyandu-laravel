<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'nama',
        'alamat_padukuhan'
    ];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function folders() {
        return $this->hasMany(Folder::class);
    }
}
