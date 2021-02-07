<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Album;
use App\Models\Image;
use App\Models\Comment;

class SearchAlbum extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire.search-album', [
            'albums' => Album::where('visibility', 1)->where('name', $this->search)->orderBy('updated_at','desc')->get(),
            'images' => Image::all()->sortByDesc("id"),
            'comments' => Comment::all()->sortByDesc("id"),
        ]);
    }
}
