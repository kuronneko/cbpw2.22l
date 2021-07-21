<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Album;
use App\Models\Image;
use App\Models\Tag;
use App\Models\Like;
use App\Models\Stat;
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
                $albums = Album::take($this->amount)->where('visibility', 1)->inRandomOrder()->get();
                $albumPlucked = $albums->pluck('id');
                return view('livewire.load-more-album', [
                    'albums' => $albums,
                    'images' => Image::whereIn('album_id', $albumPlucked->all())->get(),
                    'stats' => Stat::whereIn('album_id', $albumPlucked->all())->get(),
                    'albumMax' => $this->albumMax()
                    //'stats' => app('App\Http\Controllers\PublicAlbumController')->getCompleteStatistics()
                ]);
              }else if($this->sortBy == 'view'){
                $albums = Album::take($this->amount)->where('visibility', 1)->orderBy('view','desc')->get();
                $albumPlucked = $albums->pluck('id');
                return view('livewire.load-more-album', [
                    'albums' => $albums,
                    'images' => Image::whereIn('album_id', $albumPlucked->all())->get(),
                    'stats' => Stat::whereIn('album_id', $albumPlucked->all())->get(),
                    'albumMax' => $this->albumMax()
                    //'stats' => app('App\Http\Controllers\PublicAlbumController')->getCompleteStatistics()
                ]);
              }else{
                $albums = Album::take($this->amount)->where('visibility', 1)->orderBy('updated_at','desc')->get();
                $albumPlucked = $albums->pluck('id');
                return view('livewire.load-more-album', [
                    'albums' => $albums,
                    'images' => Image::whereIn('album_id', $albumPlucked->all())->get(),
                    'stats' => Stat::whereIn('album_id', $albumPlucked->all())->get(),
                    'albumMax' => $this->albumMax()
                    //'stats' => app('App\Http\Controllers\PublicAlbumController')->getCompleteStatistics()
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
