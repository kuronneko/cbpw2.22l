<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public function user(){ //$libro->categoria->nombre
        return $this->belongsTo(User::class, 'user_id'); //Pertenece a una categoría.
    }
}
