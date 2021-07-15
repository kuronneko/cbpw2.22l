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
        $this->validate([
            'photo' => 'required|mimes:gif,png,jpg,jpeg|max:10000'
        ]);

        if(auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++') || auth()->user()->type == config('myconfig.privileges.super')){
            if($this->photo == ''){

            }else{
                $user = User::findOrFail($this->userId);
                $newFilename = md5($this->photo->getClientOriginalName());

                $userFolderPath = public_path('/storage/images/' . 'profile_'.$user->id);
                if (!file_exists($userFolderPath)) {       //check if folder exist

                    mkdir($userFolderPath, 0755, true);
                }
                $filePath = public_path('/storage/images/' . $user->id . '/' . $newFilename . '.' . $this->photo->getClientOriginalExtension());
                if (!file_exists($filePath)){
                    $this->photo->storeAs('public/images/' . 'profile_'.$user->id, $newFilename . '.' . $this->photo->getClientOriginalExtension()); //upload main file

                    $thumbTarget = public_path('/storage/images/' . 'profile_'.$user->id . '/' . $newFilename . '_thumb.' . $this->photo->getClientOriginalExtension()); //generate thumbnail with intervention image library
                    ImageManagerStatic::make($this->photo->getRealPath())->resize(200, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->resizeCanvas(200, null)->save($thumbTarget, 80);
                }

                if($user->avatar == config('myconfig.img.avatar')){

                }else{
                    $productImage = str_replace('/storage', '', $user->avatar);
                    Storage::delete('/public' . $productImage);
                }

                  $user->avatar = Storage::url('public/images/' . 'profile_'.$user->id . '/' . $newFilename. '_thumb.' .$this->photo->getClientOriginalExtension()); //url without extension
                  $user->save();
                  $this->photo = '';
                  $this->emit('updateAvatar');
                  session()->flash('message', 'Avatar successfully updated.');
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
                session()->flash('message', 'Avatar deleted successfully.');
            }
        }else{
            session()->flash('message', 'You do not have sufficient privileges to do this.');
        }

    }
}
