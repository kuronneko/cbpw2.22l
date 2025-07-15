<?php

namespace App\Http\Livewire\Super;

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
            if ($this->createImage == "true") {
                //$this->dispatchBrowserEvent('loadDropzone');
                return view('escort.image.livewire.create-image', [
                    'album' => $album,

                ]);
            } else {
                return view('super.image.livewire.image-gestor', [
                    'images' => Image::where('album_id', $album->id)->orderBy('id', 'desc')->paginate(100),
                    'album' => $album,

                ]);
            }
        }
    }


    public function deleteImage($imageId)
    {
        $userId = auth()->user()->id;
        $albumFound = Album::findOrFail($this->albumId);
        $imageFound = Image::findOrFail($imageId);
        $statFound = Stat::where('album_id', $albumFound->id)->first();

        if (($imageFound->album->id == $albumFound->id && $albumFound->user->id == $userId && (auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++'))) || ($imageFound->album->id == $albumFound->id && auth()->user()->type == config('myconfig.privileges.super'))) {

            $productImage = str_replace('/storage', '', $imageFound->url);

            if ($imageFound->ext == "mp4" || $imageFound->ext == "webm") {
                if ($statFound->qvideo == 0) {
                } else {
                    $statFound->qvideo = $statFound->qvideo - 1;
                }
            } else {
                if ($statFound->qimage == 0) {
                } else {
                    $statFound->qimage = $statFound->qimage - 1;
                }
            }
            $statFound->size = $statFound->size - $imageFound->size;
            $statFound->save();


            if (config('filesystems.default') === 's3') {
                $folder = config('filesystems.disks.s3.upload_folder');
                $imagePath = $folder . '/' . preg_replace('/^' . preg_quote($folder, '/') . '\//', '', ltrim(parse_url($imageFound->url . '.' . $imageFound->ext, PHP_URL_PATH), '/'));
                $thumbImagePath = $folder . '/' . preg_replace('/^' . preg_quote($folder, '/') . '\//', '', ltrim(parse_url($imageFound->url . '_thumb.' . $imageFound->ext, PHP_URL_PATH), '/'));

                if (Storage::disk('s3')->exists($imagePath)) {
                    Storage::disk('s3')->delete($imagePath);
                }
                if (Storage::disk('s3')->exists($thumbImagePath)) {
                    Storage::disk('s3')->delete($thumbImagePath);
                }
            } else {
                Storage::delete('/public' . $productImage . '.' . $imageFound->ext);
                if ($imageFound->ext == "mp4" || $imageFound->ext == "webm") {  //fix video thumbnail delete
                    Storage::delete('/public' . $productImage . '_thumb.jpg');
                } else {
                    Storage::delete('/public' . $productImage . '_thumb.' . $imageFound->ext);
                }
            }

            $imageFound->delete();

            session()->flash('message', 'You deleted image successfully.');
        } else {
            return back()->with('message', 'Image ' . $imageFound->id . ' not found or cannot be accessed');
        }
    }
}
