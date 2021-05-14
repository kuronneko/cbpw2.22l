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


    public function premiumUser($userId){
        $user = User::findOrFail($userId);
        if(auth()->user()->type == config('myconfig.privileges.super')){
            $user->type = config('myconfig.privileges.admin++');
            $user->update();
            Album::where('user_id', $user->id)->where('visibility', 1)->update(['visibility' => 0]);
            $this->emit('refreshAlbum');$this->emit('refreshUsers');
        }else{
            abort_if(auth()->user()->type != config('myconfig.privileges.super'), 204);
        }
    }

    public function premiumUserPlus($userId){
        $user = User::findOrFail($userId);
        if(auth()->user()->type == config('myconfig.privileges.super')){
            $user->type = config('myconfig.privileges.admin+++');
            $user->update();
            Album::where('user_id', $user->id)->where('visibility', 0)->update(['visibility' => 1]);
            $this->emit('refreshAlbum');$this->emit('refreshUsers');
        }else{
            abort_if(auth()->user()->type != config('myconfig.privileges.super'), 204);
        }
    }

    public function restrinctedUser($userId){
        $user = User::findOrFail($userId);
        if(auth()->user()->type == config('myconfig.privileges.super')){
            $user->type = config('myconfig.privileges.admin');
            $user->update();
            Album::where('user_id', $user->id)->where('visibility', 1)->update(['visibility' => 0]);
            $this->emit('refreshAlbum');$this->emit('refreshUsers');
        }else{
            abort_if(auth()->user()->type != config('myconfig.privileges.super'), 204);
        }
    }

    public function deleteUser($userId){

        if(auth()->user()->type == config('myconfig.privileges.super')){


                $albumIdList = array();
                $albumIdList = Album::where('user_id', $userId);
                dd($albumIdList->id);
                //$albums->whereIn('id', $AlbumIdList[])->get()->delete();
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
