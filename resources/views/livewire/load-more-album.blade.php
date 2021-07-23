<div wire:init="initOne">

@if (empty($albums))

        <div class="text-center">
            <div class="page-load-status mt-4 mb-4">
                <div class="loader-ellips infinite-scroll-request">
                  <span class="loader-ellips__dot"></span>
                  <span class="loader-ellips__dot"></span>
                  <span class="loader-ellips__dot"></span>
                  <span class="loader-ellips__dot"></span>
                </div>
              </div>
        </div>
            @else
            <nav class="navbar navbar-expand-lg navbar-dark filterBar mb-4">
              <div class="container">
                  <div class="btn-group btn-block text-center">
                      <a wire:loading.remove wire:target="sortBy('view')" wire:click="sortBy('view')" class="btn blackBtn btn-sm userMenuBtn text-white" href="#"><i class="fas fa-redo"></i> Sort by Views</a>
                      <a wire:loading wire:target="sortBy('view')" class="btn blackBtn btn-sm userMenuBtn text-white" href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i> Sort by Views</a>
                      <a wire:loading.remove wire:target="sortBy('random')" wire:click="sortBy('random')" class="btn blackBtn btn-sm userMenuBtn text-white" href="#"><i class="fas fa-dice"></i> Sort by Random</a>
                      <a wire:loading wire:target="sortBy('random')" class="btn blackBtn btn-sm userMenuBtn text-white" href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i> Sort by Random</a>
                      <a wire:loading.remove wire:target="$emit('showModal')" wire:click="$emit('showModal')" type="button" class="btn blackBtn btn-sm text-white userMenuBtn"><i class="fas fa-chart-bar"></i> Stats</a>
                      <a wire:loading wire:target="$emit('showModal')" type="button" class="btn blackBtn btn-sm text-white userMenuBtn"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i> Stats</a>
                  </div>
              </div>
          </nav>
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-md-12">
            <div class="row" id="albumsBox">
                @foreach ($albums as $album)
                <?php $imageLimitperAlbum = 0;?>

                    <div class="col-12 col-sm-4">
                <div class="card text-white indexCard mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                    <small><strong><p class="cardAlbumTittle upperCaseTittles text-danger" alt="{{$album->name}}">{{$album->name}}</p></strong></small><small><p class="cardAlbumTittle lowerCaseTittles text-secondary">By: {{$album->user->name}}</p></small>
                    </div>
                    <div class="card-body cardIndexBodyPadding">
                        <p class="text-secondary dateIndexCard">{{$album->updated_at;}}</p>
                        @if ( session('message') )
                        <div class="alert alert-success">{{ session('message') }}</div>
                      @endif
                      <p class="cardAlbumDescription" alt="{{$album->description}}">Description: {{$album->description}}</p>

                    <div class="text-center">

                        @foreach ($images as $image)
                        @if (empty($image->album_id))
                            @else
                            @if($image->album_id == $album->id)
                            @if($imageLimitperAlbum != 4)
                            <?php $imageLimitperAlbum++; ?>
                            @if (($image->ext == "mp4" || $image->ext == "webm") && ($image->id <= config('myconfig.patch-pre-ffmpeg.image-id-less')))
                            <img src="{{ config("myconfig.img.url") }}{{'/img/videothumb.png'}}" class="imgThumbPublicIndex " data-was-processed='true'>
                            @elseif ($image->ext == "mp4" || $image->ext == "webm")
                            <img src="{{ config("myconfig.img.url") }}{{ $image->url }}_thumb.jpg" class="imgThumbPublicIndex " data-was-processed='true'>
                            @else
                            <img src="{{ config("myconfig.img.url") }}{{ $image->url }}_thumb.{{$image->ext}}" class="imgThumbPublicIndex " data-was-processed='true'>
                            @endif
                            @endif
                            @endif
                        @endif
                        @endforeach
                    </div>
                        <div>
                            @foreach ($stats as $stat)
                            @if($stat->album->id == $album->id)
                            <span class="badge badge-Light"><i class="fas fa-images"></i><span class="badge badge-Light">{{$stat->qimage}}</span></span>
                            <span class="badge badge-Light"><i class="fas fa-film"></i><span class="badge badge-Light">{{$stat->qvideo}}</span></span>
                            <span class="badge badge-Light"><i class="fas fa-comments"></i><span class="badge badge-Light">{{$stat->qcomment}}</span></span>
                            <span class="badge badge-Light"><i class="fas fa-eye"></i><span class="badge badge-Light">{{$stat->view}}</span></span>
                            <span class="badge badge-Light"><i class="fas fa-heart"></i><span class="badge badge-Light">{{$stat->qlike}}</span></span>
                            <span class="badge badge-Light"><i class="fas fa-hdd"></i><span class="badge badge-Light"><?php echo app('App\Http\Controllers\PublicImageController')->formatSizeUnits($stat->size);?></span></span>
                            @endif
                            @endforeach
                        </div>

                    {{-- fin card body --}}
                    </div>
                    <div class="card-footer">
                        @foreach ($album->tags as $albumtags)
                           <span class="badge badge-danger"><i class="fas fa-tag"></i><span alt="#{{$albumtags->name}}" class="badge badge-danger">{{$albumtags->name}}</span></span>
                        @endforeach
                        <a href="{{route('image.content', $album->id)}}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
                @endforeach

        </div>
        <div class="row justify-content-center">
        <div class="col-md-12">
            @if ($albumMax == 0)

        @else
        <button wire:loading.remove wire:target='load' wire:click='load' class="btn loadBtn btn-sm btn-block text-white mb-2">
            Load more
            </button>
        <button wire:loading wire:target='load' wire:loading class="btn loadBtn btn-sm btn-block mb-2">
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
        </div>
      </div>
   </div>
</div>

@endif

</div>

