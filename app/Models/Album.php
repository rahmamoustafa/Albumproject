<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Picture;
class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function user(){
        $this->belongsTo(User::class,'user_id','id');
    }

    public function pictures(){
       return  $this->hasMany(Picture::class,'album_id','id');
    }
}
