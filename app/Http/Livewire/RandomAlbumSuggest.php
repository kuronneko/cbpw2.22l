<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Album;
use App\Models\Image;
use App\Models\Comment;

class RandomAlbumSuggest extends Component
{
    public function render()
    {
        $album = Album::where('visibility', 1)->inRandomOrder()->first();
        if(empty($album)){
            $empty = 0;
            return view('livewire.random-album-suggest', ['empty' => $empty,]);
        }
        $images = Image::where('album_id' , $album->id)->inRandomOrder()->take(3)->get();
        $images2 = Image::where('album_id' , $album->id)->inRandomOrder()->take(3)->get();
        $images3 = Image::where('album_id' , $album->id)->inRandomOrder()->take(3)->get();

        $comments = Comment::where('album_id' , $album->id)->orderBy('id','desc')->get();

        $commentsType = app('App\Http\Controllers\PublicCommentController')->getCommentType($album->id); //return array with ['comment'] paginate and ['commentFull'] full coments;
        $imagesFull = Image::where('album_id', $album->id)->orderBy('id','desc')->get();
        $stats = app('App\Http\Controllers\PublicImageController')->getAlbumStats($imagesFull, $album, $commentsType);

        return view('livewire.random-album-suggest', [
            'album' => $album,
            'images' => $images,
            'images2' => $images2,
            'images3' => $images3,
            'comments' => $comments,
            'stats' => $stats,
            'empty' => 1,
        ]);
    }
}
