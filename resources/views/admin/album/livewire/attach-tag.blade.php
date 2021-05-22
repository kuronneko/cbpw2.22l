<div>
    <div id="tagsComponent">
     <h5>Album Tags</h5>
                @foreach ($album->tags as $albumtags)
                     <button wire:loading.remove wire:target="destroy({{$albumtags->id}},{{$album->id}})" wire:click="destroy({{$albumtags->id}},{{$album->id}})" class="btn btn-dark btn-sm my-2">{{$albumtags->name}} <i class="fas fa-backspace"></i></button>
                     <button disabled wire:loading wire:target="destroy({{$albumtags->id}},{{$album->id}})" class="btn btn-dark btn-sm my-2">{{$albumtags->name}} <i class="spinner-border spinner-border-sm"></i></button>
                @endforeach
    <hr>
    <h5>Avalible Tags</h5>
    @foreach ($tags as $tag)
       <button wire:loading.remove wire:target="attach({{$tag->id}},{{$album->id}})" wire:click="attach({{$tag->id}},{{$album->id}})" class="btn btn-success btn-sm my-2">{{$tag->name}} <i class="fas fa-plus"></i></button>
       <button disabled wire:loading wire:target="attach({{$tag->id}},{{$album->id}})" class="btn btn-success btn-sm my-2">{{$tag->name}} <i class="spinner-border spinner-border-sm"></i></button>
    @endforeach

    </div>
</div>
