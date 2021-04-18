<?php

namespace App\Http\Livewire\Super;

use Livewire\Component;
use App\Models\Tag;

class TagGestor extends Component
{

    public $name;

    public function render()
    {
        if(auth()->user()->type == 1){
            return view('super.tag.livewire.tag-gestor', [
                'tags' => Tag::all(),
            ]);
        }
    }

    public function destroy($id){
        //Tag::destroy($id);
        if(auth()->user()->type == 1){
            $tag = Tag::find($id);
            $tag->albums()->detach();
            $tag->delete();
        }
    }

    public function store(){
        if(auth()->user()->type == 1){
            $this->validate(['name' => 'required']);
            Tag::create([
                'name' => $this->name,
            ]);
            $this->name = "";
        }
    }
}
