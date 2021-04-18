<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Album;
use App\Models\Image;
use App\Models\Tag;
use App\Models\Comment;

class LoadMoreAlbum extends Component
{

    public $amount = 6;
    public function render()
    {
        return view('livewire.load-more-album', [
            'albums' => Album::take($this->amount)->where('visibility', 1)->orderBy('updated_at','desc')->get(),
            'images' => Image::all()->sortByDesc("id"),
            'comments' => Comment::all()->sortByDesc("id"),
            'tags' => Tag::all()->sortByDesc("id"),
            'albumMax' => $this->albumMax(),
        ]);
    }

    public function load(){
        $this->amount += 6;
    }

    public function albumMax(){
        $albumMax = count(Album::where('visibility', 1)->orderBy('updated_at','desc')->get());
        if ($albumMax <= $this->amount){
            return 0;
        }else{
            return 1;
        }
    }


}
