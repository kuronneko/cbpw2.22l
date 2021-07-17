<?php

namespace App\Http\Livewire\Super;

use Livewire\Component;
use App\Models\Tag;

class TagGestor extends Component
{

    public $name;

    public function render()
    {
        if(auth()->user()->type == config('myconfig.privileges.super')){
            return view('super.tag.livewire.tag-gestor', [
                'tags' => Tag::all(),
            ]);
        }
    }

    public function destroy($id){
        //Tag::destroy($id);
        if(auth()->user()->type == config('myconfig.privileges.super')){
            $tag = Tag::find($id);
            $tag->albums()->detach();
            $tag->delete();
            session()->flash('message', 'You removed a tag successfully.');
        }
    }

    public function store(){
        if(auth()->user()->type == config('myconfig.privileges.super')){
            $this->validate(['name' => 'required']);
            Tag::create([
                'name' => $this->name,
            ]);
            $this->name = "";
            session()->flash('message', 'Add a tag successfully.');
        }
    }
}
