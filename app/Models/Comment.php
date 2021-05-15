<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function album(){ //$comment->album->id
        return $this->belongsTo(Album::class, 'album_id'); //Pertenece a un album.
    }
    public function user(){ //$album->user->id
        return $this->belongsTo(User::class, 'user_id'); //Pertenece a un usuario.
    }
}
