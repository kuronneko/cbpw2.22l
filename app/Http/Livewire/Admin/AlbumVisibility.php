<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Album;
use Illuminate\Support\Facades\Auth;

class AlbumVisibility extends Component
{

    public $albumId;

    public function render()
    {
        if(Auth::check()){
            return view('admin.album.livewire.album-visibility', [
                'foundAlbum' => Album::find($this->albumId),
            ]);
        }else{
            abort_if(!Auth::check(), 204);
        }
    }

    public function changeVisibility(){

        $userId = auth()->user()->id;
        $foundAlbum = Album::find($this->albumId);

        if(Auth::check() && $foundAlbum->user->id == $userId){
            if($foundAlbum->visibility == 0){
                $foundAlbum->visibility = 1;
                $foundAlbum->update();
            }else if($foundAlbum->visibility == 1){
                $foundAlbum->visibility = 0;
                $foundAlbum->update();
            }
        }else{
            abort_if(!Auth::check() || $foundAlbum->user->id != $userId, 204);
        }

    }

}
