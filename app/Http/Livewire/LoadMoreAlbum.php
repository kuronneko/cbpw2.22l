<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Album;
use App\Models\Image;
use App\Models\Tag;
use App\Models\Like;
use App\Models\Comment;

class LoadMoreAlbum extends Component
{

    public $amount = 6;
    public $readyToLoad = false;
    public $sortBy = "";

    protected $queryString = [
        'sortBy' => ['except' => ''],
   ];
    public function render()
    {
           if($this->readyToLoad){
              if($this->sortBy == 'random'){
                return view('livewire.load-more-album', [
                    'albums' => Album::take($this->amount)->where('visibility', 1)->inRandomOrder()->get(),
                    'images' => Image::all()->sortByDesc("id"),
                    'comments' => Comment::all()->sortByDesc("id"),
                    'tags' => Tag::all()->sortByDesc("id"),
                    'likes' => Like::all()->sortByDesc("id"),
                    'albumMax' => $this->albumMax(),
                    'stats' => app('App\Http\Controllers\PublicAlbumController')->getCompleteStatistics()
                ]);
              }else if($this->sortBy == 'view'){
                return view('livewire.load-more-album', [
                    'albums' => Album::take($this->amount)->where('visibility', 1)->orderBy('view','desc')->get(),
                    'images' => Image::all()->sortByDesc("id"),
                    'comments' => Comment::all()->sortByDesc("id"),
                    'tags' => Tag::all()->sortByDesc("id"),
                    'likes' => Like::all()->sortByDesc("id"),
                    'albumMax' => $this->albumMax(),
                    'stats' => app('App\Http\Controllers\PublicAlbumController')->getCompleteStatistics()
                ]);
              }else{
                return view('livewire.load-more-album', [
                    'albums' => Album::take($this->amount)->where('visibility', 1)->orderBy('updated_at','desc')->get(),
                    'images' => Image::all()->sortByDesc("id"),
                    'comments' => Comment::all()->sortByDesc("id"),
                    'tags' => Tag::all()->sortByDesc("id"),
                    'likes' => Like::all()->sortByDesc("id"),
                    'albumMax' => $this->albumMax(),
                    'stats' => app('App\Http\Controllers\PublicAlbumController')->getCompleteStatistics()
                ]);
              }
           }else{
            return view('livewire.load-more-album');
           }
    }

    public function sortBy($name){
         $this->sortBy = $name;
    }


    public function load(){
        $this->amount += 6;
    }


    public function initOne(){
        $this->readyToLoad = true;
    }

    public function albumMax(){
        $albumMax = count(Album::where('visibility', 1)->orderBy('updated_at','desc')->get());
        if ($albumMax <= $this->amount){
            return 0;
        }else{
            return 1;
        }
    }


}
