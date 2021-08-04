<?php

namespace App\Http\Livewire\Admin;

use App\Models\Album;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Stat;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class DeleteAlbumModal extends Component
{
    protected $listeners = ['deleteAlbumModal'];
    public $name,$descripton,$visibility;
    public $album;
    public function render()
    {
        return view('admin.album.livewire.delete-album-modal',[
            'album' => $this->album,
        ]);
    }
    public function deleteAlbum(){
        $userId = auth()->user()->id;
        $foundAlbum = $this->album;

    if(($foundAlbum->user->id == $userId && (auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++'))) || auth()->user()->type == config('myconfig.privileges.super')){
        $images = Image::where('album_id', $foundAlbum->id);
        $images->delete();
        $comments = Comment::where('album_id', $foundAlbum->id);
        $comments->delete();
        $likes = Like::where('album_id', $foundAlbum->id);
        $likes->delete();
        $stat = Stat::where('album_id', $foundAlbum->id);
        $stat->delete();
        $foundAlbum->tags()->detach();

        $folderPath = 'public/images/' . 'profile_'.$userId.'/'. $foundAlbum->id;
        if (Storage::exists($folderPath)) {  //check if folder exist
            Storage::deleteDirectory($folderPath);
        }

        $foundAlbum->delete();
        $this->dispatchBrowserEvent('close-deleteAlbumModal');
        $this->emit('refreshAlbum');
        session()->flash('message', 'You deleted Album successfully.');
    }else{
        return back()->with('message', 'Album '.$foundAlbum->id.' not found or cannot be accessed');
    }
    }

    public function deleteAlbumModal($albumId){
        $this->album = Album::findOrFail($albumId);
        $this->name = $this->album->name;
        $this->descripton = $this->album->descripton;
        $this->visibility = $this->album->visibility;
        $this->dispatchBrowserEvent('show-deleteAlbumModal');
    }
}
