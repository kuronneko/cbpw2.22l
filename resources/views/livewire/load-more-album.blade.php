<div wire:init="initOne">
    <nav class="navbar navbar-expand-lg navbar-dark filterBar mb-4">
        <div class="container">
            <div class="btn-group btn-block">
                <a wire:click="sortBy('view')" class="btn blackBtn btn-sm userMenuBtn text-white" href="#"><i class="fas fa-redo"></i> Sort by Views</a>
                <a wire:click="sortBy('random')" class="btn blackBtn btn-sm userMenuBtn text-white" href="#"><i class="fas fa-dice"></i> Sort by Random</a>
                <button type="button" class="btn blackBtn btn-sm text-white userMenuBtn" data-toggle="modal" data-target="#stats">
                    <i class="fas fa-chart-bar"></i> Stats
                </button>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-12">
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
            <div class="row" id="albumsBox">
                @foreach ($albums as $album)
                <?php $videoCountperAlbum = 0;$imageLimitperAlbum = 0;$imageCountperAlbum = 0;$updated_at = $album->updated_at;
                $albumSize = 0;$commentCountperAlbum = 0;$view = $album->view;$likesCountperAlbum = 0;?>
                    <div class="col-12 col-sm-4">
                <div class="card text-white indexCard mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                    <small><strong><p class="cardAlbumTittle upperCaseTittles text-danger">{{$album->name}}</p></strong></small><small><p class="cardAlbumTittle lowerCaseTittles text-secondary">By: {{$album->user->name}}</p></small>
                    </div>
                    <div class="card-body cardIndexBodyPadding">
                        <p class="text-secondary dateIndexCard"><?php echo $updated_at;?></p>
                        @if ( session('message') )
                        <div class="alert alert-success">{{ session('message') }}</div>
                      @endif
                      <p class="cardAlbumDescription">Description: {{$album->description}}</p>

                    <div class="text-center">
                        @foreach ($comments as $comment)
                            @if ($comment->album->id == $album->id)
                            <?php $commentCountperAlbum++; ?>
                            @endif
                        @endforeach
                        @foreach ($likes as $like)
                        @if ($like->album->id == $album->id)
                        <?php $likesCountperAlbum++; ?>
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
                        @if (($image->ext == "mp4" || $image->ext == "webm") && ($image->id <= config('myconfig.patch-pre-ffmpeg.image-id-less')))
                        <img src="{{ config("myconfig.img.url") }}{{'/img/videothumb.png'}}" class="imgThumbPublicIndex " data-was-processed='true'>
                        @elseif ($image->ext == "mp4" || $image->ext == "webm")
                        <img src="{{ config("myconfig.img.url") }}{{ $image->url }}_thumb.jpg" class="imgThumbPublicIndex " data-was-processed='true'>
                        @else
                        <img src="{{ config("myconfig.img.url") }}{{ $image->url }}_thumb.{{$image->ext}}" class="imgThumbPublicIndex " data-was-processed='true'>
                        @endif
                        @endif
                        @endif
                        @endforeach
                    </div>
                        <div>
                        <span class="badge badge-Light"><i class="fas fa-images"></i><span class="badge badge-Light"><?php echo $imageCountperAlbum;?></span></span>
                        <span class="badge badge-Light"><i class="fas fa-film"></i><span class="badge badge-Light"><?php echo $videoCountperAlbum;?></span></span>
                        <span class="badge badge-Light"><i class="fas fa-comments"></i><span class="badge badge-Light"><?php echo $commentCountperAlbum;?></span></span>
                        <span class="badge badge-Light"><i class="fas fa-eye"></i><span class="badge badge-Light"><?php echo $view;?></span></span>
                        <span class="badge badge-Light"><i class="fas fa-heart"></i><span class="badge badge-Light"><?php echo $likesCountperAlbum;?></span></span>
                        <span class="badge badge-Light"><i class="fas fa-hdd"></i><span class="badge badge-Light"><?php echo app('App\Http\Controllers\PublicImageController')->formatSizeUnits($albumSize);?></span></span>
                        </div>


                    {{-- fin card body --}}
                    </div>
                    <div class="card-footer">
                        @foreach ($album->tags as $albumtags)
                           <span class="badge badge-danger"><i class="fas fa-tag"></i><span class="badge badge-danger">{{$albumtags->name}}</span></span>
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
        <button wire:click='load' wire:loading.remove class="btn loadBtn btn-sm btn-block text-white mb-2">
        Load more
        </button>
        <button wire:loading class="btn loadBtn btn-sm btn-block mb-2">
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

 <!-- The Modal -->
 <div class="modal fade" id="stats">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-white">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Cyberpunkwaifus statistics</h4>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">

                <div class="container mt-3">
                    <p>General statistics collected from album content (private albums will not be counted)</p>
                    <ul class="list-group">
                      <li class="list-group-item d-flex justify-content-between align-items-center text-white">
                        Total Public Albums
                        <span class="badge badge-dark"><i class="fas fa-book"></i><span class="badge badge-dark">{{$stats['totalPublicAlbums']}}</span></span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center text-white">
                        Total Public Images
                        <span class="badge badge-dark"><i class="fas fa-images"></i><span class="badge badge-dark">{{$stats['totalPublicImages']}}</span></span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center text-white">
                        Total Public Videos
                        <span class="badge badge-dark"><i class="fas fa-film"></i><span class="badge badge-dark">{{$stats['totalPublicVideos']}}</span></span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center text-white">
                        Total Public Comments
                        <span class="badge badge-dark"><i class="fas fa-comments"></i></i><span class="badge badge-dark">{{$stats['totalPublicComments']}}</span></span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center text-white">
                        Total Public Likes
                        <span class="badge badge-dark"><i class="fas fa-heart"></i></i><span class="badge badge-dark">{{$stats['totalPublicLikes']}}</span></span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center text-white">
                        Total Views
                        <span class="badge badge-dark"><i class="fas fa-eye"></i><span class="badge badge-dark">{{$stats['totalPublicViews']}}</span></span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center text-white">
                        Total Size
                        <span class="badge badge-dark"><i class="fas fa-hdd"></i><span class="badge badge-dark">{{$stats['totalAlbumSize']}}</span></span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center text-white">
                        Last update at
                        <span class="badge badge-dark"><i class="fas fa-redo-alt"></i><span class="badge badge-dark">{{$stats['lastUpdateAlbum']}}</span></span>
                      </li>
                    </ul>
                  </div>

        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>
@endif

</div>

