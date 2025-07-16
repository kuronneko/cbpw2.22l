<?php

namespace App\Http\Livewire\Super;

use App\Models\User;
use App\Models\Album;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\AvatarService;
use App\Services\DeleteImagesService;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;

class UploadAvatar extends Component
{
    protected $listeners = ['refreshMainAvatar' => 'render'];
    use WithFileUploads;
    public $photo;
    public $userId;

    public function render()
    {
        return view('super.profile.livewire.upload-avatar',[
        'user' => User::findOrFail($this->userId),
        ]);
    }

    public function updatedPhoto()
    {
        AvatarService::configureImageDriver();

        $this->validate([
            'photo' => 'required|mimes:mp4,webm,gif,png,jpg,jpeg|max:10240' // 10 MB max file size
        ]);

        if (AvatarService::hasAdminPrivileges()) {
            if ($this->photo != '') {
                $newFilename = md5($this->photo->getClientOriginalName());
                $websiteTag = config('myconfig.engine.nameext') . '_';
                $imgWaterMarkPath = config('myconfig.img.avatarWatermarkUrl');

                $url = AvatarService::processImage($this->photo, $this->userId, $newFilename, $websiteTag, $imgWaterMarkPath);

                AvatarService::updateUserAvatar($this->userId, $url);

                session()->flash('message', 'Foto de perfil actualizada correctamente');

                $this->emit('updateAvatar');
                $this->emit('refreshProfile');
            }
        } else {
            session()->flash('error', 'No tienes los suficientes privilegios para realizar esta acción');
        }
    }

    public function destroy()
    {
        $user = User::findOrFail($this->userId);

        if (AvatarService::hasAdminPrivileges()) {
            if ($user->avatar != config('myconfig.img.avatar')) {

                DeleteImagesService::deleteAvatarImages($user);

                $user->avatar = config('myconfig.img.avatar');
                $user->save();

                Album::where('user_id', $user->id)->first()->touch();

                $this->photo = '';
                $this->emit('updateAvatar');
                $this->emit('refreshProfile');
                session()->flash('message', 'Foto de perfil borrada correctamente');
                $this->render();
            }
        } else {
            session()->flash('error', 'No tienes los suficientes privilegios para realizar esta acción');
        }
    }
}

