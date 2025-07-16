<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Album;
use App\Models\Image;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class RandomAlbumSuggest extends Component
{
    public function render()
    {
        // Check if user is super admin (type 5) to show all albums
        if (Auth::check() && auth()->user()->type == 5) {
            $album = Album::inRandomOrder()->first();
        } else {
            $album = Album::where('visibility', 1)->inRandomOrder()->first();
        }

        if(empty($album)){
            $empty = 0;
            return view('livewire.random-album-suggest', ['empty' => $empty,]);
        }
        $images = Image::where('album_id' , $album->id)->inRandomOrder()->take(3)->get();
        $images2 = Image::where('album_id' , $album->id)->inRandomOrder()->take(3)->get();
        $images3 = Image::where('album_id' , $album->id)->inRandomOrder()->take(3)->get();

        return view('livewire.random-album-suggest', [
            'album' => $album,
            'images' => $images,
            'images2' => $images2,
            'images3' => $images3,
            'empty' => 1,
        ]);
    }
}
