<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puskesmas extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'nama',
    ];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];
    public function puskesmas() {
        return $this->belongsTo(User::class);
    }
}
