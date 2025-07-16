
<div class="relativeContainer">

    <div class="input-group">
        <div class="input-group-append">
            <button wire:loading.remove class="btn btn-dark btn-sm rounded" {{ $isRateLimited ? 'disabled' : '' }}>
                <i class="fas fa-search"></i>
            </button>
            <button wire:loading class="btn btn-dark btn-sm rounded" {{ $isRateLimited ? 'disabled' : '' }}>
                <i class="spinner-border spinner-border-sm"></i>
            </button>
        </div>
        <input wire:model.debounce.500ms="search"
               type="text"
               class="form-control text-white searchBarIndex"
               placeholder="{{ $isRateLimited ? 'Search temporarily blocked...' : 'Search albums by name' }}"
               maxlength="100"
               {{ $isRateLimited ? 'disabled' : '' }} />
    </div>

    @if (strlen($search) > 2 || $errors->has('search'))

    <div class="list-group absoluteItem rounded btn-block">

        @error('search')
            <a href="#" class="list-group-item list-group-item-action text-danger bg-dark">{{ e($message) }}</a>
        @enderror

        @if ($albums && $albums->count() > 0 && strlen($search) > 2)

                @foreach ($albums as $album)
                @php
                    $imgLimiteAlbum = 0;
                @endphp
                <a href="{{route('album.content', $album->id)}}" class="list-group-item list-group-item-action text-white bg-dark">
                   @foreach ( $images as $image)

                   @if ($image->album->id == $album->id)
                   @if($imgLimiteAlbum != 1)
                   @php
                       $imgLimiteAlbum++;
                   @endphp
                   @if (($image->ext == "mp4" || $image->ext == "webm") && !$image->thumbnail_exist)
                   <img  src="{{ config("myconfig.img.url") }}{{'storage/images/videothumb.png'}}" data-was-processed='true' class="imgThumb" alt="Album Avatar">
                   @elseif ($image->ext == "mp4" || $image->ext== "webm")
                   <img src="{{ config("myconfig.img.url") }}{{ $image->url }}_thumb.jpg" data-was-processed='true' class="imgThumb" alt="Album Avatar">
                   @else
                   <img src="{{ config("myconfig.img.url") }}{{$image->url}}_thumb.{{$image->ext}}" data-was-processed='true' class="imgThumb" alt="Album Avatar">
                   @endif
                   @endif
                   @endif

                   @endforeach
                   <span>{{ e($album->name) }}</span>
                </a>
                @endforeach

        @elseif (strlen($search) > 2 && !$errors->has('search'))
        <a href="#" class="list-group-item list-group-item-action text-white bg-dark">No results for {{ e($search) }}</a>

        @endif
    </div>
    @endif

</div>
