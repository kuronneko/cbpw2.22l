<?php

namespace App\Http\Livewire\Super;

use Livewire\Component;
use App\Models\Album;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Tag;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;
use Livewire\WithPagination;

class UserGestorTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refreshUsers' => 'render'];

    public function render()
    {
        return view('super.user.livewire.user-gestor-table',[
            'users' => User::paginate(10),
        ]);
    }
    public function userEdit($userId){
        $this->emit('listenerUserId', $userId);
    }
}
