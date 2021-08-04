<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Album;
use App\Models\Comment;
use App\Models\Image;
use App\Models\User;
use App\Models\Stat;
use Illuminate\Support\Facades\Storage;

class CommentGestor extends Component
{
    public $albumId;
    public $commentId;
    protected $paginationTheme = 'bootstrap';
    use WithPagination;

    public function render()
    {
        $userId = auth()->user()->id;
        $album = Album::findOrFail($this->albumId);

    if( ($album->user->id == $userId && (auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++'))) || auth()->user()->type == config('myconfig.privileges.super') ){
        return view('admin.comment.livewire.comment-gestor',[
            'comments' => Comment::where('album_id', $album->id)->orderBy('id','desc')->paginate(100),
            'album' => $album
        ]);
    }

    }

    public function deleteComment($commentId){
        $userId = auth()->user()->id;
        $albumFound = Album::findOrFail($this->albumId);
        $commentFound = Comment::findOrFail($commentId);
        $statFound = Stat::where('album_id', $albumFound->id)->first();

        if(($commentFound->album->id == $albumFound->id && $albumFound->user->id == $userId && (auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++'))) || ($commentFound->album->id == $albumFound->id && auth()->user()->type == config('myconfig.privileges.super'))){

            if($statFound->qcomment == 0){

            }else{
                $statFound->qcomment = $statFound->qcomment - 1;
                $statFound->save();
            }

            $commentFound->delete();

            session()->flash('message', 'You deleted comment successfully.');
        }else{
            return back()->with('message', 'Comment '.$commentFound->id.' not found or cannot be accessed');
        }
    }
}
