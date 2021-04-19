
<div class="relativeContainer mb-4">

    <div class="input-group">
        <div class="input-group-append">
            <button wire:loading.remove class="btn btn-dark btn-sm rounded"><i class="fas fa-search"></i></button>
            <button wire:loading class="btn btn-dark btn-sm rounded"><i class="spinner-border spinner-border-sm"></i></button>
          </div>
        <input wire:model.debounce.500ms="search" type="text" class="form-control text-white searchBarIndex" placeholder="Search albums by name" />
      </div>

    @if (strlen($search) > 2)

    <div class="list-group absoluteItem rounded btn-block">
        @if ($albums->count() > 0)

                @foreach ($albums as $album)
                @php
                    $imgLimiteAlbum = 0;
                @endphp
                <a href="{{route('image.content', $album->id)}}" class="list-group-item list-group-item-action text-white bg-dark">
                   @foreach ( $images as $image)

                   @if ($image->album->id == $album->id)
                   @if($imgLimiteAlbum != 1)
                   @php
                       $imgLimiteAlbum++;
                   @endphp
                   @if (($image->ext == "mp4" || $image->ext == "webm") && ($image->id <= config('myconfig.patch-pre-ffmpeg.image-id-less')))
                   <img  src="{{'/cbpw2.22l/public/storage/images/videothumb.png'}}" data-was-processed='true' class="imgThumb" alt="Album Avatar">
                   @elseif ($image->ext == "mp4" || $image->ext== "webm")
                   <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.jpg" data-was-processed='true' class="imgThumb" alt="Album Avatar">
                   @else
                   <img src="{{'/cbpw2.22l/public/'}}{{$image->url}}_thumb.{{$image->ext}}" data-was-processed='true' class="imgThumb" alt="Album Avatar">
                   @endif
                   @endif
                   @endif

                   @endforeach
                   <span>{{$album->name}}</span>
                </a>
                @endforeach

        @else
        <a href="#" class="list-group-item list-group-item-action text-white bg-dark">No results for {{$search}}</a>


        @endif
    </div>
    @endif

</div>
