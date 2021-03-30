<div>
        <div class="row" id="albumsBox">

        @foreach ($albums as $album)
        <?php $videoCountperAlbum = 0;$imageLimitperAlbum = 0;$imageCountperAlbum = 0;$updated_at = $album->updated_at;$albumSize = 0;$commentCountperAlbum = 0;$view = $album->view;?>
            <div class="col-12 col-sm-4">
        <div class="card text-white indexCard mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
            <strong><p class="cardAlbumTittle upperCaseTittles text-danger">Album: {{$album->name}}</p></strong><p class="cardAlbumTittle text-secondary">By: {{$album->user->name}}</p>
            </div>
            <div class="card-body cardIndexBodyPadding">
                <p class="text-secondary dateIndexCard"><?php echo $updated_at;?></p>
                @if ( session('message') )
                <div class="alert alert-success">{{ session('message') }}</div>
              @endif
                <p class="cardAlbumDescription">Description: {{$album->description}}</p>
            <div class="photos" wire:ignore>
                @foreach ($comments as $comment)
                    @if ($comment->album->id == $album->id)
                    <?php $commentCountperAlbum++; ?>
                    @endif
                @endforeach
                @foreach ($images as $image)
                @if($image->album->id == $album->id)
                <?php $albumSize = $albumSize + $image->size;?>
                @if ($image->ext == "mp4" || $image->ext == "webm")
                <?php $videoCountperAlbum++; ?>
                @else
                <?php $imageCountperAlbum++; ?>
                @endif
                @if($imageLimitperAlbum != 4)
                <?php $imageLimitperAlbum++; ?>
                @if ($image->ext == "mp4" || $image->ext == "webm")
                <img src="{{'/cbpw2.22l/public/storage/images/videothumb.png'}}" class="imgThumbPublicIndex masonry" data-was-processed='true'>
                @else
                <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.{{$image->ext}}" class="imgThumbPublicIndex masonry" data-was-processed='true'>
                @endif
                @endif
                @endif
                @endforeach
            </div>
            {{-- fin card body --}}
            </div>
            <div class="card-footer">
                <span class="badge badge-dark"><i class="fas fa-images"></i><span class="badge badge-dark"><?php echo $imageCountperAlbum;?></span></span>
                <span class="badge badge-dark"><i class="fas fa-film"></i><span class="badge badge-dark"><?php echo $videoCountperAlbum;?></span></span>
                <span class="badge badge-dark"><i class="fas fa-comments"></i><span class="badge badge-dark"><?php echo $commentCountperAlbum;?></span></span>
                <span class="badge badge-dark"><i class="fas fa-eye"></i><span class="badge badge-dark"><?php echo $view;?></span></span>
                <span class="badge badge-dark"><i class="fas fa-hdd"></i><span class="badge badge-dark"><?php echo app('App\Http\Controllers\PublicImageController')->formatSizeUnits($albumSize);?></span></span>
                <a href="{{route('image.content', $album->id)}}" class="stretched-link"></a>
            </div>
        </div>
    </div>
        @endforeach

</div>

<hr>
@if ($albumMax == 0)

@else
<button wire:click='load' wire:loading.remove class="btn btn-dark btn-sm btn-block">
Load more
</button>
<button wire:loading class="btn btn-dark btn-sm btn-block">
    <div class="page-load-status">
        <div class="loader-ellips infinite-scroll-request">
          <span class="loader-ellips__dot"></span>
          <span class="loader-ellips__dot"></span>
          <span class="loader-ellips__dot"></span>
          <span class="loader-ellips__dot"></span>
        </div>
      </div>
</button>

@endif




</div>
