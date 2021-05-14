<?php

namespace App\Http\Livewire\Admin;

use App\Models\Album;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AttachTag extends Component
{

    public $albumId;

    public function render()
    {
        return view('admin.album.livewire.attach-tag', [
            'tags' => Tag::all(),
            'album' => Album::find($this->albumId),
        ]);
    }

    public function attach($tagId, $albumId){

        $album = Album::find($albumId);
        $tag = Tag::find($tagId);
        if((auth()->user()->id == $album->user->id && (auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++'))) || auth()->user()->type == config('myconfig.privileges.super')){
            $album->tags()->attach($tag->id);
        }

    }

    public function destroy($tagId, $albumId){
        //Tag::destroy($id);
        $album = Album::find($albumId);
        $tag = Tag::find($tagId);
        if((auth()->user()->id == $album->user->id && (auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++'))) || auth()->user()->type == config('myconfig.privileges.super')){
            $album->tags()->detach($tag->id);
        }
    }

    public function pivotTest(){

        $album = Album::find($this->albumId);

        foreach ($album->tags as $albumtags) {
         //echo $albumtags->pivot->tag_id;
         //echo "<br>";
         //echo $albumtags->pivot->album_id;
        }

        //return $table->pivot->tag_id;
    }

}
