<?php

namespace App\Http\Livewire\Admin;

use App\Models\Album;
use App\Models\Stat;
use Livewire\Component;

class CreateModifyAlbumModal extends Component
{
    protected $listeners = ['modifyAlbumModal','createAlbumModal'];
    public $name,$description,$visibility;
    public $album;
    public $trigger = "";

    public function render()
    {
        return view('admin.album.livewire.create-modify-album-modal',[
            'album' => $this->album,
        ]);
    }

    public function modifyAlbumModal($albumId){
        $this->trigger = "modify";
        $this->album = Album::findOrFail($albumId);
        $this->name = $this->album->name;
        $this->description = $this->album->description;
        $this->visibility = $this->album->visibility;
        $this->dispatchBrowserEvent('show-createModifyAlbumModal');
    }

    public function createAlbumModal(){
        $this->trigger = "create";
        $this->album = "";
        $this->name = "";
        $this->description = "";
        $this->visibility = 1;
        $this->dispatchBrowserEvent('show-createModifyAlbumModal');
    }

    public function saveAlbum(){

        if($this->trigger == "modify"){
            if( (auth()->user()->id == $this->album->user->id && (auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++'))) || auth()->user()->type == config('myconfig.privileges.super')){
                $this->validate(['name' => 'required|min:2|max:40', 'description' => 'required|min:2|max:40', 'visibility' => 'required|integer']);
                $this->album->name = $this->name;
                $this->album->description = $this->description;
                $this->album->visibility = $this->visibility;
                $this->album->save();
                $this->dispatchBrowserEvent('close-createModifyAlbumModal');
                $this->emit('refreshAlbum');
                session()->flash('message', 'Album modify successfully');
            }else{
                session()->flash('message', 'You do not have sufficient privileges to do this.');
            }
        }elseif($this->trigger = "create"){
            if( (auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++')) || auth()->user()->type == config('myconfig.privileges.super')){
                $userId = auth()->user()->id;
                $this->validate(['name' => 'required|min:2|max:40', 'description' => 'required|min:2|max:40', 'visibility' => 'required|integer']);

                if (!file_exists(public_path('/storage/images/' . 'profile_'.$userId))) {       //check if folder exist
                    mkdir(public_path('/storage/images/' . 'profile_'.$userId), 0755, true);
                }
                    $album = new Album();
                    $album->user_id = $userId;
                    $album->name = $this->name;
                    $album->description = $this->description;
                    $album->visibility = $this->visibility;
                    $album->view = 0;
                    $album->save();

                    $stat = new Stat();
                    $stat->album_id = $album->id;
                    $stat->view = 0;
                    $stat->size = 0;
                    $stat->qcomment = 0;
                    $stat->qlike = 0;
                    $stat->qimage = 0;
                    $stat->qvideo = 0;
                    $stat->save();

                    if (!file_exists(public_path('/storage/images/' . 'profile_'.$userId.'/'.$album->id))) {       //check if folder exist
                        mkdir(public_path('/storage/images/' . 'profile_'.$userId.'/'.$album->id), 0755, true);
                    }
                    $this->dispatchBrowserEvent('close-createModifyAlbumModal');
                    $this->emit('refreshAlbum');
                    session()->flash('message', 'Album created successfully');
            }else{
                session()->flash('message', 'You do not have sufficient privileges to do this.');
            }
        }
    }

}
