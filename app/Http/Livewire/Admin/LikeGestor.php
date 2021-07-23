<?php
namespace App\Http\Livewire\Admin;

use App\Models\Like;
use App\Models\Stat;
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
        $statFound = Stat::where('album_id', $this->albumId)->first();
        if($statFound->qlike == 0){

        }else{
            $statFound->qlike = $statFound->qlike - 1;
            $statFound->save();
        }
        session()->flash('message', 'You removed this album from your favorites.');
    }
}
