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
        return view('admin.profile.livewire.upload-avatar');
    }

    public function store()
    {
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);

        $user = User::findOrFail($this->userId);
        $newFilename = md5($this->photo->getClientOriginalName());
        $url = Storage::url('public/images/' . 'profile_'.$user->id . '/' . $newFilename . '.' .$this->photo->getClientOriginalExtension()); //url without extension

        $userFolderPath = public_path('/storage/images/' . 'profile_'.$user->id);
        if (!file_exists($userFolderPath)) {       //check if folder exist

            mkdir($userFolderPath, 0755, true);
        }
        $filePath = public_path('/storage/images/' . $user->id . '/' . $newFilename . '.' . $this->photo->getClientOriginalExtension());
        if (!file_exists($filePath)){
            $this->photo->storeAs('public/images/' . 'profile_'.$user->id, $newFilename . '.' . $this->photo->getClientOriginalExtension()); //upload main file
        }

        if($user->avatar == config('myconfig.img.avatar')){

        }else{
            $productImage = str_replace('/storage', '', $user->avatar);
            Storage::delete('/public' . $productImage);
        }

          $user->avatar = $url;
          $user->save();
          $this->photo = '';
          $this->emit('updateAvatar');
    }

    public function destroy(){
        $user = User::findOrFail($this->userId);
        if($user->avatar == config('myconfig.img.avatar')){

        }else{
            $productImage = str_replace('/storage', '', $user->avatar);
            Storage::delete('/public' . $productImage);
        }

        $user->avatar = config('myconfig.img.avatar');
        $user->save();
        $this->emit('updateAvatar');
    }
}
