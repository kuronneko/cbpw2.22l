<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function album(){ //$album->image->id
        return $this->belongsTo(Album::class, 'album_id'); //Pertenece a un album.
    }
}
