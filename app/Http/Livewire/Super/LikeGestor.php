<?php
namespace App\Http\Livewire\Super;

use App\Models\Like;
use App\Models\Stat;
use Livewire\Component;
use Livewire\WithPagination;

class LikeGestor extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('super.like.livewire.like-gestor', [
            'likes' => Like::where('user_id', auth()->user()->id)->orderBy('id','desc')->paginate(50),
        ]);
    }

    public function dislike($albumId){
        $like = Like::where('album_id', $albumId)->where('user_id', auth()->user()->id);
        $like->delete();
        $statFound = Stat::where('album_id', $albumId)->first();
        if($statFound->qlike == 0){

        }else{
            $statFound->qlike = $statFound->qlike - 1;
            $statFound->save();
        }
        session()->flash('message', 'You removed this album from your favorites.');
    }
}
