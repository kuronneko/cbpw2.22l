<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Album;

class AlbumVisibility extends Component
{

    public $albumId;

    public function render()
    {
            return view('admin.album.livewire.album-visibility', [
                'foundAlbum' => $foundAlbum = Album::find($this->albumId)
            ]);
    }

    public function changeVisibility(){
        $userId = auth()->user()->id;
        $foundAlbum = Album::find($this->albumId);

        if(($foundAlbum->user->id) == $userId){
            if($foundAlbum->visibility == 0){
                $foundAlbum->visibility = 1;
                $foundAlbum->update();
            }else if($foundAlbum->visibility == 1){
                $foundAlbum->visibility = 0;
                $foundAlbum->update();
            }
        }
    }

}
