<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;

class UploadAvatar extends Component
{
    use WithFileUploads;
    public $photo;
    public $userId;

    public function render()
    {
        return view('admin.profile.livewire.upload-avatar',[
        'user' => User::findOrFail($this->userId),
        ]);
    }

    public function store()
    {
        if(config('myconfig.img.driver') == 'imagick'){
            ImageManagerStatic::configure(array('driver' => 'imagick'));
        }

        $this->validate([
            'photo' => 'required|mimes:mp4,webm,gif,png,jpg,jpeg|max:10240' //10 mb maxfilesize
        ]);

        if(auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++')
        || auth()->user()->type == config('myconfig.privileges.super')){

            if($this->photo == ''){

            }else{

                $user = User::findOrFail($this->userId);
                $newFilename = md5($this->photo->getClientOriginalName());
                $imgWaterMarkPath = config('myconfig.img.avatarWatermarkUrl');//public_path('/img/watermark.png'); //remeber check this url
                $websiteTag = config('myconfig.engine.nameext').'_';

                if (!file_exists(public_path('/storage/images/' . 'profile_'.$user->id))) {       //check if folder exist
                    mkdir(public_path('/storage/images/' . 'profile_'.$user->id), 0755, true);
                }

                if (!file_exists(public_path('/storage/images/' . 'profile_'.$user->id . '/' . $websiteTag . $newFilename . '_thumb.' . $this->photo->getClientOriginalExtension())
                && !file_exists(public_path('/storage/images/' . 'profile_'.$user->id . '/' . $websiteTag . $newFilename . '.' . $this->photo->getClientOriginalExtension())
                && !User::where('avatar', '/storage/images/' . 'profile_'.$user->id . '/' . $websiteTag . $newFilename . '_thumb.' . $this->photo->getClientOriginalExtension())->where('id', $user->id)->first()))) {             //check if physical file exis{
                    if(config('myconfig.img.avatarResize') == true){
                        if(ImageManagerStatic::make($this->photo->getRealPath())->width() > ImageManagerStatic::make($this->photo->getRealPath())->height()){ //check dimension of image
                            $imgResized = ImageManagerStatic::make($this->photo->getRealPath())->resize(config('myconfig.img.avatarResizeWidth'), null, function ($constraint) { //resize image based on width
                                $constraint->aspectRatio();
                            })->resizeCanvas(config('myconfig.img.avatarResizeWidth'), null);
                        }else{
                            $imgResized = ImageManagerStatic::make($this->photo->getRealPath())->resize(null, config('myconfig.img.avatarResizeHeight'), function ($constraint) { //Resize image based on height
                                $constraint->aspectRatio();
                            })->resizeCanvas(null, config('myconfig.img.avatarResizeHeight'));
                        }
                    }else{
                        //upload image with no resize it
                        $imgResized = ImageManagerStatic::make($this->photo->getRealPath());
                    }

                    if(config('myconfig.img.avatarWatermark') == true){
                        $imgResized->insert(ImageManagerStatic::make($imgWaterMarkPath)->resize(round($imgResized->width()/2), null, function ($constraint) { //insert and resize watermark based on imageresize width
                            $constraint->aspectRatio();
                        })->resizeCanvas(round($imgResized->width()/2), null)->opacity(50), 'center')->save(public_path('/storage/images/' . 'profile_' . $user->id .'/'. $websiteTag . $newFilename . '.' . $this->photo->getClientOriginalExtension()), 100);
                     }else{
                        $imgResized->save(public_path('/storage/images/' . 'profile_' . $user->id .'/'. $websiteTag . $newFilename . '.' . $this->photo->getClientOriginalExtension()), 100);
                     }

                         //imageThumbnails
                            //big image files require imagick drive to resize it, because GD drivers need a lot of ram to do it.
                            if(config('myconfig.img.thumbnailsAvatarFit') == true){
                                ImageManagerStatic::make($this->photo->getRealPath())->fit(config('myconfig.img.thumbnailsAvatarWidth'),config('myconfig.img.thumbnailsAvatarHeight'))->save(public_path('/storage/images/' . 'profile_'.$user->id.'/' . $websiteTag . $newFilename . '_thumb.' . $this->photo->getClientOriginalExtension()), config('myconfig.img.thumbnailsAvatarQuality'));
                                ImageManagerStatic::make($this->photo->getRealPath())->fit(config('myconfig.img.thumbnailsAvatarWidth-b'),config('myconfig.img.thumbnailsAvatarHeight-b'))->save(public_path('/storage/images/' . 'profile_'.$user->id.'/' . $websiteTag . $newFilename . '_thumb-b.' . $this->photo->getClientOriginalExtension()), config('myconfig.img.thumbnailsAvatarQuality'));
                            }else{
                                ImageManagerStatic::make($this->photo->getRealPath())->resize(config('myconfig.img.thumbnailsAvatarSize'), null, function ($constraint) {  //generate thumbnail from imgResized with watermark included, you can change it by $request->file('file')->getRealPath() without watermark
                                    $constraint->aspectRatio();
                                })->resizeCanvas(config('myconfig.img.thumbnailsAvatarSize'), null)->save(public_path('/storage/images/' . 'profile_'.$user->id.'/' . $websiteTag . $newFilename . '_thumb.' . $this->photo->getClientOriginalExtension()), config('myconfig.img.thumbnailsAvatarQuality'));
                            }


                }else{

                }

                if($user->avatar == config('myconfig.img.avatar')){
                    //do nothing if default image is
                    }else if(('/storage/images/' . 'profile_'.$user->id . '/' . $websiteTag . $newFilename . '_thumb.' . $this->photo->getClientOriginalExtension() == $user->avatar)
                    && ('/storage/images/' . 'profile_'.$user->id . '/' . $websiteTag . $newFilename . '.' . $this->photo->getClientOriginalExtension()) == (str_replace('_thumb', '', $user->avatar))){
                    //do nothing if thumbnail is same
                    }else{
                        //remove before thumbnail
                        $productImage = str_replace('/storage', '', $user->avatar);
                        $productImage2 = str_replace('_thumb', '', $productImage);
                        Storage::delete('/public' . $productImage);
                        Storage::delete('/public' . $productImage2);
                    }

                  $user->avatar = Storage::url('public/images/' . 'profile_'.$user->id . '/' . $websiteTag . $newFilename. '_thumb.' .$this->photo->getClientOriginalExtension()); //url without extension
                  $user->save();
                  $this->photo = '';
                  $this->emit('updateAvatar');
                  session()->flash('message', 'Foto de perfil actualizada correctamente');
            }

        }else{
            session()->flash('message', 'You do not have sufficient privileges to do this.');
        }
    }

    public function destroy(){
        $user = User::findOrFail($this->userId);
        if(auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++') || auth()->user()->type == config('myconfig.privileges.super')){
            if($user->avatar == config('myconfig.img.avatar')){

            }else{
                $productImage = str_replace('/storage', '', $user->avatar);
                $productImage2 = str_replace('_thumb', '', $productImage);
                Storage::delete('/public' . $productImage);
                Storage::delete('/public' . $productImage2);
                $user->avatar = config('myconfig.img.avatar');
                $user->save();
                $this->emit('updateAvatar');
                session()->flash('message', 'Foto de perfil borrada correctamente.');
                $this->render();
            }
        }else{
            session()->flash('message', 'You do not have sufficient privileges to do this.');
        }
    }
}

