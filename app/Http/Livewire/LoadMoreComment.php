<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Album;
use App\Models\Image;
use App\Models\Tag;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Else_;

class LoadMoreComment extends Component
{
    public $amount = 3;
    public $albumId;
    public $name;
    public $text;

    public function render()
    {

        return view('livewire.load-more-comment',[
            'comments' => Comment::take($this->amount)->where('album_id', $this->albumId)->orderBy('updated_at','desc')->get(),
            'commentCheck' => $this->commentCheck(),
            'album' => Album::findOrFail($this->albumId),
        ]);
    }

    public function load(){
        $this->amount += 3;
    }

    public function hidden(){
        $this->amount = 3;
    }

    public function commentCheck(){
        $commentCheck = count(Comment::where('album_id', $this->albumId)->orderBy('updated_at','desc')->get());
        if ($commentCheck <= 3){
            return 'minComments';
        }else if($commentCheck <= $this->amount){
            return 'maxComments';
        }
    }


    public function store(){
        if(Auth::check()){
            $this->name = auth()->user()->name;
        }else{
            $this->name = "Anonymous";
        }
        $this->validate(['name' => 'required', 'text' => 'required']);

        $comment = new Comment();
        $comment->album_id = $this->albumId;
        $comment->user_id = auth()->user()->id;
        $comment->name = $this->name;
        $comment->text = $this->text;
        $comment->ip = request()->ip();
        $comment->save();
        $this->name = "";$this->text= "";
        session()->flash('message', 'Post sent successfully');
    }
}
