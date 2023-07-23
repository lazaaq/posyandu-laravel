<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataCollection extends Model
{
    use HasFactory;
    protected $fillable = [
        'folder_id',
        'children_id',
        'bb',
        'tb',
        'lika',
        'lile',
    ];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];
    public function folder() {
        return $this->belongsTo(Folder::class);
    }
    public function children() {
        return $this->belongsTo(Children::class);
    }
}
