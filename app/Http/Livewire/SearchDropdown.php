<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Album;
use App\Models\Image;
use App\Models\Comment;

class SearchDropdown extends Component
{
    public $search = "";

    public function render()
    {


        if(strlen($this->search) > 2){
        return view('livewire.search-dropdown', [
            'albums' => Album::where('visibility', 1)->where('name', 'like', '%'.$this->search.'%')->orderBy('updated_at','desc')->get()->take(7),
            'images' => $images = Image::all()->sortByDesc("id"),
        ]);
    }else{
        return view('livewire.search-dropdown', [
            'albums' => "",
            'images' => "",
        ]);
    }
 }
}
