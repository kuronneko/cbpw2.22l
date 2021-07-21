<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ModalStats extends Component
{
    public $stats;
    protected $listeners = ['showModal'];

    public function render()
    {
        return view('livewire.modal-stats');
    }

    public function showModal (){
        $this->stats = app('App\Http\Controllers\PublicAlbumController')->getCompleteStatistics();
        $this->dispatchBrowserEvent('show-modal-stats');
    }

}
