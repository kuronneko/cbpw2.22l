@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <livewire:search-dropdown />
            <div class="card text-white mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    @if ($album->visibility == 1 || $album->user->id == $userId || (Auth::check() && auth()->user()->type == config('myconfig.privileges.super')))
                       @if ($album->visibility == 0)
                    <small><strong><span class="text-danger">Private Album: {{$album->name}}</span></strong></small>
                    @if ($album->user->id == $userId || (Auth::check() && auth()->user()->type == config('myconfig.privileges.super')))
                    <div class="btn-group">
                        <livewire:like-dislike :albumId="$album->id"/>
                        <a href="{{route('admin.image.createImage', $album->id)}}" class="btn btn-dark btn-sm" role="button" type="button"><i class="fas fa-plus"></i></a>
                        <a href="{{route('admin.image.showImage', $album->id)}}" class="btn btn-dark btn-sm" role="button" type="button"><i class="fas fa-eye"></i></a>
                        <a href="{{route('admin.comment.showComment', $album->id)}}" class="btn btn-dark btn-sm" role="button" type="button"><i class="fas fa-comments"></i></a>
                        <a class="btn btn-dark btn-sm" href="{{route("admin.album.edit", $album->id)}}"><i class="fas fa-edit"></i></a>
                        <a href="{{route('admin.tag.showTag', $album->id)}}" class="btn btn-dark btn-sm" role="button" type="button"><i class="fas fa-tags"></i></a>
                    </div>
                    @else
                    <livewire:like-dislike :albumId="$album->id"/>
                    @endif
                       @else
                    <small><strong><span class="text-danger upperCaseTittles">{{$album->name}}</span></strong></small>
                    @if ($album->user->id == $userId || (Auth::check() && auth()->user()->type == config('myconfig.privileges.super')))
                    <div class="btn-group">
                        <livewire:like-dislike :albumId="$album->id"/>
                        <a href="{{route('admin.image.createImage', $album->id)}}" class="btn btn-dark btn-sm" role="button" type="button"><i class="fas fa-plus"></i></a>
                        <a href="{{route('admin.image.showImage', $album->id)}}" class="btn btn-dark btn-sm" role="button" type="button"><i class="fas fa-eye"></i></a>
                        <a href="{{route('admin.comment.showComment', $album->id)}}" class="btn btn-dark btn-sm" role="button" type="button"><i class="fas fa-comments"></i></a>
                        <a class="btn btn-dark btn-sm" href="{{route("admin.album.edit", $album->id)}}"><i class="fas fa-edit"></i></a>
                        <a href="{{route('admin.tag.showTag', $album->id)}}" class="btn btn-dark btn-sm" role="button" type="button"><i class="fas fa-tags"></i></a>
                    </div>
                    @else
                    <livewire:like-dislike :albumId="$album->id"/>
                    @endif
                       @endif
                    @else
                        <strong><span>Private Album</span></strong>
                    @endif
                </div>
                <div class="card-body contentCardBodyStyle">
                    <div class="text-center">
                        <img src="{{ config("myconfig.img.url") }}{{'/img/loading.gif'}}" class="img-responsive loadingGif">
                    </div>
                    @if ($album->visibility == 1 || $album->user->id == $userId || (Auth::check() && auth()->user()->type == config('myconfig.privileges.super')))
                    <div class="grid">
                        @foreach ($images as $image)
                        @if (($image->ext == "mp4" || $image->ext == "webm") && ($image->id <= config('myconfig.patch-pre-ffmpeg.image-id-less')))
                        <div class="grid-item" >
                            <a data-fancybox="images" href="{{ config("myconfig.img.url") }}{{ $image->url }}.{{$image->ext}}">
                                <img src="{{ config("myconfig.img.url") }}{{'/img/videothumb.png'}}"  data-was-processed='true'>
                             </a>
                           </div>
                        @elseif ($image->ext == "mp4" || $image->ext == "webm")
                        <div class="grid-item" >
                         <a data-fancybox="images" href="{{ config("myconfig.img.url") }}{{ $image->url }}.{{$image->ext}}">
                            <img src="{{ config("myconfig.img.url") }}{{ $image->url }}_thumb.jpg" data-was-processed='true'>
                          </a>
                        </div>
                        @else
                        <div class="grid-item" >
                            <a data-fancybox="images" href="{{ config("myconfig.img.url") }}{{ $image->url }}.{{$image->ext}}">
                                <img src="{{ config("myconfig.img.url") }}{{ $image->url }}_thumb.{{$image->ext}}" data-was-processed='true'></a>
                        </div>
                        @endif
                        @endforeach
                    </div>
                        @else
                        <div class="text-center">
                            <i class="fas fa-lock privateAlbumIcon"></i>
                        <br><br>
                            <p><strong>You cannot access the content of this album.</strong><p>
                        </div>
                        @endif
                    @if ($album->visibility == 1 || $album->user->id == $userId || (Auth::check() && auth()->user()->type == config('myconfig.privileges.super')))

                    <div class="page-load-status mt-4">
                        <div class="loader-ellips infinite-scroll-request">
                          <span class="loader-ellips__dot"></span>
                          <span class="loader-ellips__dot"></span>
                          <span class="loader-ellips__dot"></span>
                          <span class="loader-ellips__dot"></span>
                        </div>
                      </div>
                      <hr>
                {{-- fin card body --}}
                <div class="px-4 text-center" id="tags">
                    @foreach ($album->tags as $albumtags)
                    <span class="badge badge-danger"><i class="fas fa-tag"></i><span class="badge badge-danger" alt="#{{$albumtags->name}}">{{$albumtags->name}}</span></span>
                    @endforeach
                </div>
                @endif
                </div>
            </div>
            <div class="mb-4">
                <livewire:load-more-comment :albumId="$album->id"/>
            </div>
        </div>
        @if ($album->visibility == 1 || $album->user->id == $userId || (Auth::check() && auth()->user()->type == config('myconfig.privileges.super')))
        <div class="col-md-4">
            <div class="card text-white mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <small><strong><span class="text-danger">Album details</span></strong></small>
                </div>
                <div class="card-body contentCardBodyStyleSide">
                    <div>
                        <ul class="list-group">
                        <li class="list-group-item mx-4 text-white customGroupItem upperCaseTittles"><i class="fas fa-book text-white customStatIcons text-center"></i> <strong>{{$album->name}}</strong></li>
                        <li class="list-group-item mx-4 text-white customGroupItem"><i class="fas fa-user text-white customStatIcons text-center"></i> {{$album->user->name}}</li>
                          <li class="list-group-item mx-4 text-white customGroupItem"><i class="fas fa-images text-white customStatIcons text-center"></i> {{$stats['imageCountperAlbum']}}</li>
                          <li class="list-group-item mx-4 text-white customGroupItem"><i class="fas fa-film text-white customStatIcons text-center"></i> {{$stats['videoCountperAlbum']}}</li>
                          <li class="list-group-item mx-4 text-white customGroupItem"><i class="fas fa-comments text-white customStatIcons text-center"></i> {{$stats['commentCountperAlbum']}}</li>
                          <li class="list-group-item mx-4 text-white customGroupItem"><i class="fas fa-eye text-white customStatIcons text-center"></i> {{$stats['viewCountperAlbum']}}</li>
                          <li class="list-group-item mx-4 text-white customGroupItem"><i class="fas fa-hdd text-white customStatIcons text-center"></i> {{$stats['albumSize']}}</li>
                          <li class="list-group-item mx-4 text-white customGroupItem"><i class="fas fa-redo-alt text-white customStatIcons text-center"></i> {{$stats['updated_at']}}</li>
                        </ul>
                      </div>
                </div>
            </div>
            <livewire:random-album-suggest/>
        @endif
    </div>
</div>

  <script>
$(document).ready(function(){
    var $grid = $('.grid').masonry({
        itemSelector: '.grid-item',
        // use element for option
        //columnWidth: 5,
        FitWidth: true,
        percentPosition: true,
        transitionDuration: 0
        });
var gridItemCount = $('.grid-item').length;
if(gridItemCount == 0){
  $(".loadingGif").hide();
  $(".grid").show();
}
$grid.imagesLoaded( function() {
  $(".loadingGif").hide();
  $(".grid").show();
$grid.masonry('layout');
});
   var msnry = $grid.data('masonry');
        var infScroll = new InfiniteScroll( '.grid', {
        path: '?page=@{{#}}',
        append: '.grid-item',
        outlayer: msnry,
        history: false,
        status: '.page-load-status',
        });
});
</script>
@endsection
