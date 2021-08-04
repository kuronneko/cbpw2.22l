<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Album;
use App\Models\Image;
use App\Models\User;
use App\Models\Stat;
use Illuminate\Support\Facades\Storage;

class ImageGestor extends Component
{
    public $albumId;
    public $imageId;
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    public $createImage = "";
    public function render()
    {
        $userId = auth()->user()->id;
        $album = Album::findOrFail($this->albumId);
        if (($album->user->id == $userId && (auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++'))) || auth()->user()->type == config('myconfig.privileges.super')) {
            if($this->createImage == "true"){
                $this->dispatchBrowserEvent('loadDropzone');
                return view('admin.image.livewire.create-image',[
                    'album' => $album,

                ]);
           }else{
                return view('admin.image.livewire.image-gestor',[
                    'images' => Image::where('album_id', $album->id)->orderBy('id', 'desc')->paginate(100),
                    'album' => $album,

                ]);
           }
        }
    }


    public function deleteImage($imageId){
        $userId = auth()->user()->id;
        $albumFound = Album::findOrFail($this->albumId);
        $imageFound = Image::findOrFail($imageId);
        $statFound = Stat::where('album_id', $albumFound->id)->first();

        if (($imageFound->album->id == $albumFound->id && $albumFound->user->id == $userId && (auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++'))) || ($imageFound->album->id == $albumFound->id && auth()->user()->type == config('myconfig.privileges.super'))) {

            $productImage = str_replace('/storage', '', $imageFound->url);

            if ($imageFound->ext == "mp4" || $imageFound->ext == "webm"){
                if($statFound->qvideo == 0){

                }else{
                    $statFound->qvideo = $statFound->qvideo - 1;
                }
            }else{
                if($statFound->qimage == 0){

                }else{
                    $statFound->qimage = $statFound->qimage - 1;
                }
            }
            $statFound->size = $statFound->size - $imageFound->size;
            $statFound->save();

            Storage::delete('/public' . $productImage . '.' . $imageFound->ext);
            Storage::delete('/public' . $productImage . '_thumb.' . $imageFound->ext);

            $imageFound->delete();

            session()->flash('message', 'You deleted image successfully.');
        } else {
            return back()->with('message', 'Image ' . $imageFound->id . ' not found or cannot be accessed');
        }
    }


}
