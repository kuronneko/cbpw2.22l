@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-dark text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p>Public Album List</p>
                    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#stats">
                        <i class="fas fa-chart-bar"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                            @foreach ($albums as $album)
                            <?php $videoCountperAlbum = 0;$imageLimitperAlbum = 0;$imageCountperAlbum = 0;$updated_at = $album->updated_at;$albumSize = 0;$commentCountperAlbum = 0;?>
                                <div class="col-12 col-sm-6">
                            <div class="card bg-dark text-white indexCard mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                <strong><p class="cardAlbumTittle text-danger">Album: {{$album->name}}</p></strong><p class="cardAlbumTittle text-secondary">By: {{$album->user->name}}</p>
                                </div>
                                <div class="card-body">
                                    @if ( session('message') )
                                    <div class="alert alert-success">{{ session('message') }}</div>
                                  @endif
                                    <p class="cardAlbumDescription">Description: {{$album->description}}</p>
                                <div class="photos">
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
                                    <span class="badge badge-secondary"><i class="fas fa-images"></i><span class="badge badge-secondary"><?php echo $imageCountperAlbum;?></span></span>
                                    <span class="badge badge-secondary"><i class="fas fa-film"></i><span class="badge badge-secondary"><?php echo $videoCountperAlbum;?></span></span>
                                    <span class="badge badge-secondary"><i class="fas fa-comments"></i><span class="badge badge-secondary"><?php echo $commentCountperAlbum;?></span></span>
                                    <span class="badge badge-secondary"><i class="fas fa-redo-alt"></i><span class="badge badge-secondary"><?php echo $updated_at;?></span></span>
                                    <span class="badge badge-secondary"><i class="fas fa-hdd"></i><span class="badge badge-secondary"><?php echo app('App\Http\Controllers\PublicImageController')->formatSizeUnits($albumSize);?></span></span>
                                    <a href="{{route('image.content', $album->id)}}" class="stretched-link"></a>
                                </div>
                            </div>
                        </div>
                            @endforeach
                        </div>
                        <hr>
                        {{$albums->links("pagination::bootstrap-4")}}
                {{-- fin card body --}}
                </div>
            </div>

        </div>
    </div>
</div>
      <!-- The Modal -->
      <div class="modal fade" id="stats">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content bg-dark text-white">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Cyberpunkwaifus statistics</h4>
              <button type="button" class="close bg-dark text-white" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                    <div class="container mt-3">
                        <p>General statistics collected from album content (private albums will not be counted)</p>
                        <ul class="list-group">
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Total Public Albums
                            <span class="badge badge-secondary"><i class="fas fa-book"></i><span class="badge badge-secondary">{{$stats['totalPublicAlbums']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Total Public Images
                            <span class="badge badge-secondary"><i class="fas fa-images"></i><span class="badge badge-secondary">{{$stats['totalPublicImages']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Total Public Videos
                            <span class="badge badge-secondary"><i class="fas fa-film"></i><span class="badge badge-secondary">{{$stats['totalPublicVideos']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Total Public Comments
                            <span class="badge badge-secondary"><i class="fas fa-comments"></i></i><span class="badge badge-secondary">{{$stats['totalPublicComments']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Total Size
                            <span class="badge badge-secondary"><i class="fas fa-hdd"></i><span class="badge badge-secondary">{{$stats['totalAlbumSize']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Last update at
                            <span class="badge badge-secondary"><i class="fas fa-redo-alt"></i><span class="badge badge-secondary">{{$stats['lastUpdateAlbum']}}</span></span>
                          </li>
                        </ul>
                      </div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

          </div>
        </div>
      </div>
      <script type="text/javascript">
       $(document).ready(function() {
           if ($.cookie('pop') == null) {
               $('#stats').modal('show');
               $.cookie('pop', '1');
           }
       });
      </script>
      <script>
        $(document).ready(function(){
        var $grid = $('.photos').masonry({
        itemSelector: '.masonry',
        // use element for option
        //  columnWidth: '.masonry',
        FitWidth: true,
        percentPosition: true,
        transitionDuration: 0
        });
        // layout Masonry after each image loads
        $grid.imagesLoaded().progress( function() {
        $grid.masonry('layout');
        });
        });
        </script>
@endsection

