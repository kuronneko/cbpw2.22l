<?php
namespace App\Http\Livewire\Admin;

use App\Models\Like;
use Livewire\Component;

class LikeGestor extends Component
{
    public function render()
    {
        return view('admin.like.livewire.like-gestor', [
            'likes' => Like::where('user_id', auth()->user()->id)->orderBy('id','desc')->get(),
        ]);
    }

    public function dislike($albumId){
        $like = Like::where('album_id', $albumId)->where('user_id', auth()->user()->id);
        $like->delete();
        session()->flash('message', 'You removed this album from your favorites.');
    }
}
