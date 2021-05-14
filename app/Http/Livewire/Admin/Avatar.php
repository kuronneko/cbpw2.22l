<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class Avatar extends Component
{
    protected $listeners = ['updateAvatar' => 'render'];
    public $userId;

    public function render()
    {
        return view('admin.profile.livewire.avatar',[
            'user' => User::findOrFail($this->userId),
        ]);
    }
}
