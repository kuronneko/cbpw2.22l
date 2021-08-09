<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-white">
                    <div class="text-white card-header d-flex justify-content-between align-items-center">
                        <small><span>[Album:{{$album->name}}] Tag Gestor</span></small>
                        <div class="btn-group">
                            @if ($trigger == "render")
                            <a wire:loading.remove wire:target="$emit('refreshAlbumCleneaded')" wire:click="$emit('refreshAlbumCleneaded')" type="button" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i></a>
                            <a wire:loading wire:target="$emit('refreshAlbumCleneaded')" class="btn btn-dark btn-sm" href="#content"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></a>
                            @else
                            <a href="{{url('/admin/profile?option=albums')}}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i></a>
                            @endif
                            <a href="{{route('image.content', $album->id)}}" class="btn btn-dark btn-sm"><i class="fas fa-expand-arrows-alt"></i></a>
                        </div>
                    </div>
                <div class="card-body">
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
            </div>
        </div>
    </div>


</div>
