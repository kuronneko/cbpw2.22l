<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public function user(){ //$album->user->id
        return $this->belongsTo(User::class, 'user_id'); //Pertenece a un usuario.
    }

    public function tags(){
        return $this->belongsToMany(Tag::class)->withPivot('album_id', 'tag_id');
    }
}
