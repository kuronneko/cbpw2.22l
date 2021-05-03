<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class Avatar extends Component
{
    protected $listeners = ['updateAvatar' => 'render'];

    public function render()
    {
        return view('admin.profile.livewire.avatar');
    }
}
