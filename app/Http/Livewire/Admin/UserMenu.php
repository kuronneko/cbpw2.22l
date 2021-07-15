<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class UserMenu extends Component
{
    public $option = "";
    protected $queryString = [
        'option' => ['except' => ''],
   ];

    public function render()
    {
            return view('admin.profile.livewire.user-menu');
    }

    public function changeOption($optionName){
        $this->option = $optionName;
    }

}
