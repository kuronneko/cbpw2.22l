<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Album;
use App\Models\Image;
use App\Models\Tag;
use App\Models\Like;
use App\Models\Stat;
use App\Models\DB;
use App\Models\Comment;
use App\Models\EmbedVideo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;

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
                if(Auth::check() && auth()->user()->type == config('myconfig.privileges.super')){
                    $albums = Album::take($this->amount)->inRandomOrder()->get();
                }else{
                    $albums = Album::take($this->amount)->where('visibility', 1)->inRandomOrder()->get();
                }
               $stats = Stat::whereIn('album_id', $albums->pluck('id'))->get();
               $embedvideos = EmbedVideo::whereIn('album_id', $albums->pluck('id'))->get();
               $images = collect();
               foreach ($albums as $album) {
                   $images->add(Image::where('album_id', $album->id)->orderBy('id', 'desc')->first());
                   $images->add(Image::where('album_id', $album->id)->orderBy('id', 'desc')->skip(1)->first());
                   $images->add(Image::where('album_id', $album->id)->orderBy('id', 'desc')->skip(2)->first());
                   $images->add(Image::where('album_id', $album->id)->orderBy('id', 'desc')->skip(3)->first());
               }

               //dd($images);
               return view('livewire.load-more-album', [
                   'albums' => $albums,
                   'images' => $images,
                   'stats' => $stats,
                   'albumMax' => $this->albumMax($albums),
                   'embedvideos' => $embedvideos,
               ]);
             }else if($this->sortBy == 'view'){
                //dd($images);
                //$albums = Album::whereIn('id', $statsPlucked->all())->get();
                //dd($albums);
                if(Auth::check() && auth()->user()->type == config('myconfig.privileges.super')){
                    $stats = Stat::orderBy('view', 'desc')->get();
                }else{
                    $stats = Stat::whereIn('album_id', Album::where('visibility', 1)->get()->pluck('id'))->orderBy('view', 'desc')->get();
                }
                $albums = Album::take($this->amount)->whereIn('id', $stats->pluck('album_id'))->orderByRaw('FIELD(id,'.implode(',', $stats->pluck('album_id')->toArray()).')')->get();
                $embedvideos = EmbedVideo::whereIn('album_id', $albums->pluck('id'))->get();
                $images = collect();
                foreach ($albums as $album) {
                    $images->add(Image::where('album_id', $album->id)->orderBy('id', 'desc')->first());
                    $images->add(Image::where('album_id', $album->id)->orderBy('id', 'desc')->skip(1)->first());
                    $images->add(Image::where('album_id', $album->id)->orderBy('id', 'desc')->skip(2)->first());
                    $images->add(Image::where('album_id', $album->id)->orderBy('id', 'desc')->skip(3)->first());
                }
                return view('livewire.load-more-album', [
                    'albums' => $albums,
                    'images' => $images,
                    'stats' =>  $stats,
                    'albumMax' => $this->albumMax($albums),
                    'embedvideos' => $embedvideos,
                ]);
              }else{
                if(Auth::check() && auth()->user()->type == config('myconfig.privileges.super')){
                    $albums = Album::take($this->amount)->orderBy('updated_at','desc')->get();
                }else{
                    $albums = Album::take($this->amount)->where('visibility', 1)->orderBy('updated_at','desc')->get();
                }
               $stats = Stat::whereIn('album_id', $albums->pluck('id'))->get();
               $embedvideos = EmbedVideo::whereIn('album_id', $albums->pluck('id'))->get();
               $images = collect();
               foreach ($albums as $album) {
                   $images->add(Image::where('album_id', $album->id)->orderBy('id', 'desc')->first());
                   $images->add(Image::where('album_id', $album->id)->orderBy('id', 'desc')->skip(1)->first());
                   $images->add(Image::where('album_id', $album->id)->orderBy('id', 'desc')->skip(2)->first());
                   $images->add(Image::where('album_id', $album->id)->orderBy('id', 'desc')->skip(3)->first());
               }
               //dd($images);
               return view('livewire.load-more-album', [
                   'albums' => $albums,
                   'images' => $images,
                   'stats' => $stats,
                   'albumMax' => $this->albumMax($albums),
                   'embedvideos' => $embedvideos,
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

    public function albumMax($albums){
        if (count($albums) >= $this->amount){
            return 1;
        }else{
            return 0;
        }
    }


}
