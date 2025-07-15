<?php

namespace App\Http\Livewire\Super;

use App\Models\Like;
use App\Models\Stat;
use App\Models\Album;
use App\Models\Image;
use App\Models\Comment;
use Livewire\Component;
use App\Models\EmbedVideo;
use App\Services\DeleteImagesService;
use Illuminate\Support\Facades\Storage;

class DeleteAlbumModal extends Component
{
    protected $listeners = ['deleteAlbumModal'];
    public $name, $descripton, $visibility;
    public $album;
    public function render()
    {
        return view('super.album.livewire.delete-album-modal', [
            'album' => $this->album,
        ]);
    }
    public function deleteAlbum()
    {
        $userId = auth()->user()->id;
        $foundAlbum = $this->album;

        if (($foundAlbum->user->id == $userId && (auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++'))) || auth()->user()->type == config('myconfig.privileges.super')) {
            $images = Image::where('album_id', $foundAlbum->id);
            $images->delete();
            $comments = Comment::where('album_id', $foundAlbum->id);
            $comments->delete();
            $likes = Like::where('album_id', $foundAlbum->id);
            $likes->delete();
            $foundStat = Stat::where('album_id', $foundAlbum->id)->first();
            if ($foundStat) {
                $foundStat->delete();
            }
            $foundAlbum->tags()->detach();

            DeleteImagesService::deleteAlbumFolder($foundAlbum);

            $foundAlbum->delete();
            //$foundAlbum->user->delete(); // dont delete the user, just the album

            $this->dispatchBrowserEvent('close-deleteAlbumModal');
            $this->emit('refreshAlbum');
            session()->flash('message', 'You deleted Album successfully.');
        } else {
            return back()->with('message', 'Album ' . $foundAlbum->id . ' not found or cannot be accessed');
        }
    }

    public function deleteAlbumModal($albumId)
    {
        $this->album = Album::findOrFail($albumId);
        $this->name = $this->album->name;
        $this->descripton = $this->album->descripton;
        $this->visibility = $this->album->visibility;
        $this->dispatchBrowserEvent('show-deleteAlbumModal');
    }
}
