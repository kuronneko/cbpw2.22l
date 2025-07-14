<?php

namespace App\Http\Livewire\Super;

use Livewire\Component;
use App\Models\Album;
use App\Models\Image;
use App\Models\User;
use App\Models\Stat;
use Livewire\WithPagination;

class AlbumGestor extends Component
{
    protected $listeners = ['refreshAlbum' => 'render', 'refreshAlbumCleneaded'];
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $subOption;
    public $subOptionId;

    public function refreshAlbumCleneaded(){
        $this->subOption = "";
        $this->subOptionId = "";
    }

    public function render()
    {

        $userId = auth()->user()->id;

        if(auth()->user()->type == config('myconfig.privileges.super')){
            $albums = Album::orderBy('id', 'desc')->paginate(50);
            $albumPlucked = $albums->pluck('id');
            return view('super.album.livewire.album-gestor', [
                'albums' => $albums,
                'stats' => Stat::whereIn('album_id', $albumPlucked->all())->get(),

            ]);
        }else{
            $albums = Album::where('user_id', $userId)->orderBy('id','desc')->paginate(50);
            $albumPlucked = $albums->pluck('id');
            return view('super.album.livewire.album-gestor', [
                'albums' => $albums,
                'stats' => Stat::whereIn('album_id', $albumPlucked->all())->get(),

            ]);
        }

    }

    public function createAlbumModal(){
        $this->emit('createAlbumModal');
    }

    public function modifyAlbumModal($albumId){
        $this->emit('modifyAlbumModal', $albumId);
    }

    public function deleteAlbumModal($albumId){
        $this->emit('deleteAlbumModal', $albumId);
    }

    public function showTagGestorAtt($albumId){
        $this->subOptionId = $albumId;
        $this->subOption = "showTagGestorAtt";
    }

    public function showCreateImage($albumId){
        $this->subOptionId = $albumId;
        $this->subOption = "showCreateImage";
    }

    public function showCommentGestor($albumId){
        $this->subOptionId = $albumId;
        $this->subOption = "showCommentGestor";
    }

    public function showImageGestor($albumId){
    $this->subOptionId = $albumId;
    $this->subOption = "showImageGestor";
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
