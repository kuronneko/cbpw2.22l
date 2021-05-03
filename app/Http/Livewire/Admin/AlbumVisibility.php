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
        $userId = auth()->user()->id;
        $foundAlbum = Album::find($this->albumId);

        if($foundAlbum->user->id == $userId || auth()->user()->type == config('myconfig.privileges.super')){
            return view('admin.album.livewire.album-visibility', [
                'foundAlbum' => Album::find($this->albumId),
            ]);
        }else{
            abort_if(auth()->user()->type != 1 || $foundAlbum->user->id != $userId, 204);
        }
    }

    public function changeVisibility(){

        $userId = auth()->user()->id;
        $foundAlbum = Album::find($this->albumId);

        if($foundAlbum->user->id == $userId || auth()->user()->type == config('myconfig.privileges.super')){
            if($foundAlbum->visibility == 0){
                $foundAlbum->visibility = 1;
                $foundAlbum->update();
            }else if($foundAlbum->visibility == 1){
                $foundAlbum->visibility = 0;
                $foundAlbum->update();
            }
        }else{
            abort_if(auth()->user()->type != 1 || $foundAlbum->user->id != $userId, 204);
        }

    }

}
