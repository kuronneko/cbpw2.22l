<?php

namespace App\Http\Livewire\Admin;

use App\Models\EmbedVideo;
use Livewire\Component;
use App\Models\Album;
use App\Models\Image;
use App\Models\Stat;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use Lakshmaji\Thumbnail\Facade\Thumbnail;
use Livewire\WithFileUploads;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class CreateModifyAlbumModal extends Component
{
    use WithFileUploads;
    protected $listeners = ['modifyAlbumModal','createAlbumModal'];
    public $name, $description, $visibility, $type, $url, $host;
    public $album,$embedvideo,$file;
    public $trigger = "";

    public function render()
    {
        return view('admin.album.livewire.create-modify-album-modal',[
            'album' => $this->album,
        ]);
    }

    public function modifyAlbumModal($albumId){
        $this->trigger = "modify";
        $this->album = Album::findOrFail($albumId);
        $this->name = $this->album->name;
        $this->description = $this->album->description;
        $this->visibility = $this->album->visibility;
        $this->type = $this->album->type;
        $this->embedvideo = EmbedVideo::where('album_id', $this->album->id)->first();
        if($this->embedvideo){
            $this->host = $this->embedvideo->host;
            $this->url = $this->embedvideo->url;
            $this->file = '';
        }else{
            $this->host = "";
            $this->url = "";
            $this->file = '';
        }
        $this->dispatchBrowserEvent('show-createModifyAlbumModal');
    }

    public function createAlbumModal(){
        $this->trigger = "create";
        $this->album = "";
        $this->name = "";
        $this->description = "";
        $this->visibility = 1;
        $this->type = 0;
        $this->host = 'steamsb';
        $this->url = '';
        $this->file = '';
        $this->dispatchBrowserEvent('show-createModifyAlbumModal');
    }

    public function saveAlbum(){

        if($this->trigger == "modify"){
            if( (auth()->user()->id == $this->album->user->id && (auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++'))) || auth()->user()->type == config('myconfig.privileges.super')){
                $this->validate(['name' => 'required|min:2|max:40', 'description' => 'required|min:2|max:40',
                'visibility' => 'required|integer', 'type' => 'required|integer']);
                $this->album->name = $this->name;
                $this->album->description = $this->description;
                $this->album->visibility = $this->visibility;
                $this->album->type = $this->type;
                $this->album->save();
                if($this->album->type == config('myconfig.albumType.embedvideo')){
                    $this->embedvideo->url = $this->url;
                    if($this->embedvideo->preview){

                    }else{
                        $this->embedvideo->preview = $this->uploadPreview($this->file, $this->album, User::findOrFail($this->album->user->id));
                    }
                    $this->embedvideo->host = $this->host;
                    $this->embedvideo->save();
                }
                $this->dispatchBrowserEvent('close-createModifyAlbumModal');
                $this->emit('refreshAlbum');
                session()->flash('message', 'Album modify successfully');
            }else{
                session()->flash('message', 'You do not have sufficient privileges to do this.');
            }
        }elseif($this->trigger = "create"){
            if( (auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++')) || auth()->user()->type == config('myconfig.privileges.super')){

                $userId = auth()->user()->id;

                $this->validate(['name' => 'required|min:2|max:40', 'description' => 'required|min:2|max:40', 'visibility' => 'required|integer',
                'type' => 'required|integer']);

                if (!file_exists(public_path('/storage/images/' . 'profile_'.$userId))) {       //check if folder exist
                    mkdir(public_path('/storage/images/' . 'profile_'.$userId), 0755, true);
                }
                    $album = new Album();
                    $album->user_id = $userId;
                    $album->name = $this->name;
                    $album->description = $this->description;
                    $album->visibility = $this->visibility;
                    $album->type = $this->type;
                    //$album->view = 0; // deprecated
                    $album->save();

                    if($album->type == config('myconfig.albumType.embedvideo')){
                        $embedvideo = new EmbedVideo();
                        $embedvideo->album_id = $album->id;
                        $embedvideo->preview = $this->uploadPreview($this->file, $album, User::findOrFail($userId));
                        $embedvideo->url = $this->url;
                        $embedvideo->host = $this->host;
                        $embedvideo->save();
                    }

                    $stat = new Stat();
                    $stat->album_id = $album->id;
                    $stat->view = 0;
                    $stat->size = 0;
                    $stat->qcomment = 0;
                    $stat->qlike = 0;
                    $stat->qimage = 0;
                    $stat->qvideo = 0;
                    $stat->save();

                    if (!file_exists(public_path('/storage/images/' . 'profile_'.$userId.'/'.$album->id))) {       //check if folder exist
                        mkdir(public_path('/storage/images/' . 'profile_'.$userId.'/'.$album->id), 0755, true);
                    }
                    $this->dispatchBrowserEvent('close-createModifyAlbumModal');
                    $this->emit('refreshAlbum');
                    session()->flash('message', 'Album created successfully');
            }else{
                session()->flash('message', 'You do not have sufficient privileges to do this.');
            }
        }
    }

    public function uploadPreview($file, $album, $user)
    {
        if(config('myconfig.img.driver') == 'imagick'){
            ImageManagerStatic::configure(array('driver' => 'imagick'));
        }

        if(auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++')
        || auth()->user()->type == config('myconfig.privileges.super')){

            if($file == ''){

            }else{

                $newFilename = md5($file->getClientOriginalName());
                $imgWaterMarkPath = config('myconfig.img.avatarWatermarkUrl');//public_path('/img/watermark.png'); //remeber check this url
                $websiteTag = config('myconfig.engine.nameext').'_';
                $embedvideo = EmbedVideo::where('album_id', $album->id)->first();

                if (!file_exists(public_path('/storage/images/' . 'profile_'.$user->id.'/'.$album->id))) {       //check if folder exist
                    mkdir(public_path('/storage/images/' . 'profile_'.$user->id.'/'.$album->id), 0755, true);
                }

                if (!file_exists(public_path('/storage/images/' . 'profile_'.$user->id .'/'.$album->id . '/' . $websiteTag . $newFilename . '_preview_thumb.' . $file->getClientOriginalExtension())
                && !file_exists(public_path('/storage/images/' . 'profile_'.$user->id .'/'.$album->id . '/' . $websiteTag . $newFilename . '_preview.' . $file->getClientOriginalExtension())
                && !EmbedVideo::where('preview', '/storage/images/' . 'profile_'.$user->id .'/'.$album->id . '/' . $websiteTag . $newFilename . '_preview_thumb.' . $file->getClientOriginalExtension())->where('album_id', $album->id)->first()))) {             //check if physical file exis{

                        $imgResized = ImageManagerStatic::make($file->getRealPath());
                        $imgResized->save(public_path('/storage/images/' . 'profile_' . $user->id .'/'.$album->id. '/' . $websiteTag . $newFilename . '_preview.' . $file->getClientOriginalExtension()), 100);
                         //imageThumbnails
                            //big image files require imagick drive to resize it, because GD drivers need a lot of ram to do it.
                        ImageManagerStatic::make($file->getRealPath())->resize(config('myconfig.img.thumbnailsAvatarSize'), null, function ($constraint) {  //generate thumbnail from imgResized with watermark included, you can change it by $request->file('file')->getRealPath() without watermark
                            $constraint->aspectRatio();
                        })->resizeCanvas(config('myconfig.img.thumbnailsAvatarSize'), null)->save(public_path('/storage/images/' . 'profile_'.$user->id.'/'.$album->id. '/' . $websiteTag . $newFilename . '_preview_thumb.' . $file->getClientOriginalExtension()), config('myconfig.img.thumbnailsAvatarQuality'));
                }else{

                }

                  if($embedvideo){
                    if($embedvideo->preview == ''){
                        //do nothing if default image is
                        }else if(('/storage/images/' . 'profile_'.$user->id .'/'.$album->id. '/' . $websiteTag . $newFilename . '_preview_thumb.' . $file->getClientOriginalExtension() == $embedvideo->preview)
                        && ('/storage/images/' . 'profile_'.$user->id .'/'.$album->id. '/' . $websiteTag . $newFilename . '_preview.' . $file->getClientOriginalExtension()) == (str_replace('_thumb', '', $embedvideo->preview))){
                        //do nothing if thumbnail is same
                        }else{
                            //remove before thumbnail
                            $productImage = str_replace('/storage', '', $embedvideo->preview);
                            $productImage2 = str_replace('_thumb', '', $productImage);
                            Storage::delete('/public' . $productImage);
                            Storage::delete('/public' . $productImage2);
                        }
                  }

                  return Storage::url('public/images/' . 'profile_'.$user->id .'/'.$album->id. '/' . $websiteTag . $newFilename. '_preview_thumb.' .$file->getClientOriginalExtension()); //url without extension
            }

        }else{
            session()->flash('message', 'You do not have sufficient privileges to do this.');
        }
    }

}
