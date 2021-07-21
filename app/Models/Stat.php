<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    public function album(){ //$comment->album->id
        return $this->belongsTo(Album::class, 'album_id'); //Pertenece a un album.
    }
}
