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

                            <?php $imageLimitperAlbum = 0;$imageCountperAlbum = 0;$updated_at = "";$albumSize = 0;?>
                                <div class="col-12 col-sm-6">
                            <div class="card bg-dark text-white indexCard">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                <p class="cardAlbumTittle">[Album:{{$album->name}}]</p><p class="cardAlbumTittle">[User:{{$album->user->name}}]</p>
                                </div>
                                <div class="card-body">
                                    @if ( session('message') )
                                    <div class="alert alert-success">{{ session('message') }}</div>
                                  @endif
                                    <p class="cardAlbumDescription">Description: {{$album->description}}</p>
                                <div class="photos">
                                    @foreach ($images as $image)
                                    @if($image->album->id == $album->id)
                                    <?php $albumSize = $albumSize + $image->size;?>
                                    @if ($imageCountperAlbum == 0)
                                    <?php $updated_at = $image->updated_at?>
                                    @endif
                                    <?php $imageCountperAlbum++ ?>
                                    @if($imageLimitperAlbum != 4)
                                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}thumb.{{$image->ext}}" class="imgThumbPublicIndex masonry" data-was-processed='true'>
                                    <?php $imageLimitperAlbum++ ?>
                                    @endif
                                    @endif
                                    @endforeach
                                </div>
                                {{-- fin card body --}}
                                </div>
                                <div class="card-footer">
                                    <span class="badge badge-secondary"><i class="fas fa-images"></i><span class="badge badge-secondary"><?php echo $imageCountperAlbum?></span></span>
                                    <span class="badge badge-secondary"><i class="fas fa-redo-alt"></i><span class="badge badge-secondary"><?php echo $updated_at?></span></span>
                                    <span class="badge badge-secondary"><i class="fas fa-hdd"></i><span class="badge badge-secondary"><?php echo app('App\Http\Controllers\PublicImageController')->formatSizeUnits($albumSize)?></span></span>
                                    <a href="{{route('image.content', $album->id)}}" class="stretched-link"></a>
                                </div>
                            </div>
                            <br>
                        </div>

                            @endforeach
                        </div>
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

                <?php $totalPublicAlbums = 0;$totalPublicImages = 0;$albumSize = 0;$lastImageUploaded = "";?>
                @foreach ($albums as $album)
                        @foreach ($images as $image)
                        @if($image->album->id == $album->id)
                        @if ($totalPublicImages == 0)
                        <?php $lastImageUploaded = $image->updated_at?>
                        @endif
                        <?php $albumSize = $albumSize + $image->size;?>
                        <?php $totalPublicImages++ ?>
                        @endif
                        @endforeach
                        <?php $totalPublicAlbums++ ?>
                @endforeach

                    <div class="container mt-3">
                        <p>General statistics collected from album content (private albums will not be counted)</p>
                        <ul class="list-group">
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Total Public Albums
                            <span class="badge badge-secondary"><i class="fas fa-book"></i><span class="badge badge-secondary"><?php echo $totalPublicAlbums?></span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Total Public Images
                            <span class="badge badge-secondary"><i class="fas fa-images"></i><span class="badge badge-secondary"><?php echo $totalPublicImages?></span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Total Size
                            <span class="badge badge-secondary"><i class="fas fa-hdd"></i><span class="badge badge-secondary"><?php echo app('App\Http\Controllers\PublicImageController')->formatSizeUnits($albumSize)?></span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Last image added
                            <span class="badge badge-secondary"><i class="fas fa-images"></i><span class="badge badge-secondary"><?php echo $lastImageUploaded?></span></span>
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
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.min.js"></script>
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

