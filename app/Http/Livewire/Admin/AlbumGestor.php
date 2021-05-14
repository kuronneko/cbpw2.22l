<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Album;
use App\Models\Image;
use App\Models\User;
use Livewire\WithPagination;

class AlbumGestor extends Component
{
    protected $listeners = ['refreshAlbum' => 'render'];
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {

        $userId = auth()->user()->id;

        if(auth()->user()->type == config('myconfig.privileges.super')){
            return view('admin.album.livewire.album-gestor', [
                'albums' => Album::orderBy('id', 'desc')->paginate(50),
                'images' => Image::all(),

            ]);
        }else{
            return view('admin.album.livewire.album-gestor', [
                'albums' => Album::where('user_id', $userId)->orderBy('id','desc')->paginate(50),
                'images' => Image::all(),

            ]);
        }

    }

    public function userEdit($userId){
        $this->emit('listenerUserId', $userId);
    }


    public function changeVisibility($albumId){

        $userId = auth()->user()->id;
        $foundAlbum = Album::find($albumId);

        if(($foundAlbum->user->id == $userId && auth()->user()->type == config('myconfig.privileges.admin+++')) || auth()->user()->type == config('myconfig.privileges.super')){
            if($foundAlbum->visibility == 0){
                $foundAlbum->visibility = 1;
                $foundAlbum->update();
            }else if($foundAlbum->visibility == 1){
                $foundAlbum->visibility = 0;
                $foundAlbum->update();
            }
        }else{
            return back()->with('message', 'You do not have sufficient privileges to do this');
            //abort_if(auth()->user()->type != 1 || $foundAlbum->user->id != $userId, 204);
        }

    }
}
