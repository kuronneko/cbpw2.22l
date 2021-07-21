<?php

namespace App\Http\Livewire;

use App\Models\Like;
use App\Models\Album;
use App\Models\Stat;
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

        $stat = Stat::where('album_id', $this->albumId)->first();
        if($stat){
            $stat->qlike = $stat->qlike + 1;
            $stat->save();
            Album::findOrFail($this->albumId)->touch();
        }else{
            $stat = new Stat();
            $stat->album_id = $this->albumId;
            $stat->size = 0;
            $stat->qimage = 0;
            $stat->qvideo = 0;
            $stat->qcomment = 0;
            $stat->qlike = 1;
            $stat->view = 0;
            $stat->save();
            Album::findOrFail($this->albumId)->touch();
        }

        session()->flash('message', 'You added this album to your favorites.');
       }else{
        session()->flash('message', 'Only registered users can do this.');
       }
    }

    public function dislike(){
        $like = Like::where('album_id', $this->albumId)->where('user_id', $this->userSessionId);
        $like->delete();
        $statFound = Stat::where('album_id', $this->albumId)->first();
        $statFound->qlike = $statFound->qlike - 1;
        $statFound->save();
        session()->flash('message', 'You removed this album from your favorites.');
    }

}
