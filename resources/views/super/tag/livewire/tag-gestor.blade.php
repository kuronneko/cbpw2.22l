<div>
    @include('super.tag.livewire.tag-form')
    <div id="tagsComponent">
        @foreach ($tags as $tag)

                    <button wire:loading.remove wire:target="destroy({{$tag->id}})" wire:click="destroy({{$tag->id}})" class="btn btn-dark btn-sm" value="{{$tag->id}}">
                         {{$tag->name}} <i class="fas fa-backspace"></i>
                    </button>
                    <button disabled wire:loading wire:target="destroy({{$tag->id}})" class="btn btn-danger btn-sm" value="{{$tag->id}}">
                         {{$tag->name}} <i class="spinner-border spinner-border-sm"></i>
                    </button>


        @endforeach
    </div>
</div>
