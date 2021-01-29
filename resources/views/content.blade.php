@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-white mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    @if ($album->visibility == 1)
                        <p class="text-danger">Album: {{$album->name}}</p>
                    @else
                        <p>Private Album</p>
                    @endif
                    <a href="{{route('index')}}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-home"></i>
                    </a>
                </div>
                <div class="card-body">
                    @if ($album->visibility == 1)
                    <div class="grid">
                        @foreach ($images as $image)
                        <a data-fancybox="images" href="{{'/cbpw2.22l/public/'}}{{ $image->url }}.{{$image->ext}}"><img class="grid-item" src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.{{$image->ext}}" data-was-processed='true'></a>
                        @endforeach
                        @else
                        <div class="text-center">
                            <i class="fas fa-lock privateAlbumIcon"></i>
                        <br><br>
                            <p><strong>You cannot access the content of this album.</strong><p>
                        </div>
                        @endif
                    </div>
                    @if ($album->visibility == 1)
                    <hr>
                    {{$images->links("pagination::bootstrap-4")}}
                {{-- fin card body --}}
                @endif
                </div>
            </div>

        </div>
        @if ($album->visibility == 1)
        <div class="col-md-4">
            <div class="card bg-dark text-white mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p>Album statistics</p>
                </div>
                <div class="card-body">
                    <div class="container">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                                Created by
                                <span class="badge badge-secondary"><i class="fas fa-user"></i><span class="badge badge-secondary">{{$album->user->name}}</span></span>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                                Album name
                                <span class="badge badge-secondary"><i class="fas fa-book"></i><span class="badge badge-secondary">{{$album->name}}</span></span>
                              </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Total Images
                            <span class="badge badge-secondary"><i class="fas fa-images"></i><span class="badge badge-secondary">{{$stats['imageCountperAlbum']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Total Size
                            <span class="badge badge-secondary"><i class="fas fa-hdd"></i><span class="badge badge-secondary">{{$stats['albumSize']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Last update at
                            <span class="badge badge-secondary"><i class="fas fa-redo-alt"></i><span class="badge badge-secondary">{{$stats['updated_at']}}</span></span>
                          </li>
                        </ul>
                      </div>
                </div>
            </div>
            <div class="card bg-dark text-white mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p>Comments</p>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<script>
    $(document).ready(function(){
var $grid = $('.grid').masonry({
itemSelector: '.grid-item',
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
