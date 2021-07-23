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
            $albums = Album::where('visibility', 1)->where('name', 'like', '%'.$this->search.'%')->orderBy('updated_at','desc')->get()->take(7);
            //$albumPlucked = $albums->pluck('id');
            $images = collect();
            foreach ($albums as $album) {
                $images->add(Image::where('album_id', $album->id)->orderBy('id', 'desc')->first());
            }
        return view('livewire.search-dropdown', [
            'albums' => $albums,
            'images' => $images
        ]);
    }else{
        return view('livewire.search-dropdown', [
            'albums' => "",
            'images' => "",
        ]);
    }
 }

}
