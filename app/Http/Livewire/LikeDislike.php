<?php

namespace App\Http\Livewire;

use App\Models\Like;
use App\Models\Album;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikeDislike extends Component
{

    public $albumId;
    public $userSessionId;

    public function render()
    {
        if(Auth::check()){
            $this->userSessionId = auth()->user()->id;
            return view('livewire.like-dislike',[
                'like' => Like::where('album_id', $this->albumId)->where('user_id', $this->userSessionId)->first(),
                'totalLikes' => Like::where('album_id', $this->albumId)->count(),
                'album' => Album::findOrFail($this->albumId),
            ]);
        }else{
            return view('livewire.like-dislike',[
                'totalLikes' => Like::where('album_id', $this->albumId)->count(),
            ]);
        }
    }

    public function like(){
       if(Auth::check()){
        $like = new like();
        $like->user_id = auth()->user()->id;
        $like->album_id = $this->albumId;
        //$like->status = 1;
        $like->save();
        session()->flash('message', 'You added this album to your favorites.');
       }else{
        session()->flash('message', 'Only registered users can do this.');
       }
    }

    public function dislike(){
        $like = Like::where('album_id', $this->albumId)->where('user_id', $this->userSessionId);
        $like->delete();
        session()->flash('message', 'You removed this album from your favorites.');
    }

}
