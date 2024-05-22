<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Album;

class Picture extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'album_id',
    ];

    public function album(){
        return $this->belongsTo(Album::class,'album_id','id');
    }
}
