<?php

namespace App\Http\Livewire\Super;

use Livewire\Component;
use App\Models\Album;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Tag;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;

class UserGestor extends Component
{
    protected $listeners = ['listenerUserId'];
    public $muser;
    public $userId;

    public function render()
    {
        return view('super.user.livewire.user-gestor');
    }

    public function listenerUserId($userId){
        $this->userId = $userId;
        $this->muser = User::findOrFail($userId);
        $this->dispatchBrowserEvent('show-modal');
    }


    public function changePrivileges($userId){
        $user = User::findOrFail($userId);
        if(auth()->user()->type == config('myconfig.privileges.super')){
            if($user->type == config('myconfig.privileges.admin')){
                $user->type = config('myconfig.privileges.admin++');
                $user->update();
                $this->emit('refreshAlbum');
            }else if($user->type == config('myconfig.privileges.admin++')){
                $user->type = config('myconfig.privileges.admin');
                $user->update();
                $this->emit('refreshAlbum');
            }
        }else{
            abort_if(auth()->user()->type != config('myconfig.privileges.super'), 204);
        }
    }

    public function deleteUser($userId){
        $user = User::findOrFail($userId);
        if(auth()->user()->type == config('myconfig.privileges.super')){
                $albums = Album::where('user_id', $user->id);
                foreach ($albums as $album) {
                  dump($album->id);
                    $images = Image::where('album_id', $album->id);
                    $images->delete();
                    $comments = Comment::where('album_id', $album->id);
                    $comments->delete();
                    $album->tags()->detach();
                }
                /*
                $folderPath = 'public/images/' . 'profile_'.$user->id;
                if (Storage::exists($folderPath)) {  //check if folder exist
                    Storage::deleteDirectory($folderPath);
                }
                */
                //$albums->delete();
                //$user->delete();
                $this->emit('refreshAlbum');
        }else{
            abort_if(auth()->user()->type != config('myconfig.privileges.super'), 204);
        }
    }
}
