
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mt-2">
        <div class="sponsor-desktop">
            <!-- JuicyAds v3.1 -->
        <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
        <ins id="960790" data-width="728" data-height="102"></ins>
        <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':960790});</script>
        <!--JuicyAds END-->
        </div>
        <div class="sponsor-mobile text-center">
        <!-- JuicyAds v3.1 -->
        <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
        <ins id="960824" data-width="300" data-height="112"></ins>
        <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':960824});</script>
        <!--JuicyAds END-->
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="searchBarContentContainer">
                <livewire:search-dropdown />
            </div>
            <div class="card text-white mb-4 bg-transparent border-0">
                <div class="card-body">
                    <div class="text-center container-video">
                        <IFRAME class="responsive-iframe" SRC="{{$embedvideo->url}}" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO WIDTH=640 HEIGHT=360 allowfullscreen></IFRAME>
                    </div>
                    <div>
                        @if ($album->visibility == 1 || $album->user->id == $userId || (Auth::check() && auth()->user()->type == config('myconfig.privileges.super')))
                        @if ($album->visibility == 0)
                    <div class="row">
                        <div class="col-md-6 col-6">
                           <strong><h3 class="text-white">Private Album: {{$album->name}}</h3></strong>
                           <span>{{$stat->view}}</span>
                        </div>
                        <div class="col-md-6 col-6 text-right">
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
                         </div>
                    </div>
                        @else
                     <div class="row mt-3">
                         <div class="col-md-6 col-6">
                            <strong><h3 class="text-white upperCaseTittles">{{$album->name}}</h3></strong>
                            <span class="small">{{$stat->view}} Views - {{$album->created_at}}</span>
                         </div>
                         <div class="col-md-6 col-6 text-right">
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
                     </div>
                    </div>
                    <hr class="bg-dark">
                    <div class="row">
                        <div class="col-1 col-md-1">
                            <div class="float-left mr-4">
                                <img src="{{config('myconfig.img.url')}}{{$album->user->avatar}}" class="avatarComment" alt="avatar">
                            </div>
                        </div>
                        <div class="col-3 col-md-3">
                            <strong><h5 class="mt-md-2">{{$album->user->name}}</h5></strong>
                        </div>
                        <div class="col-md-12 mt-3">
                            <span class="float-left mr-4">{{$album->description}}</span>
                        </div>
                    </div>
                    @if ($album->visibility == 1 || $album->user->id == $userId || (Auth::check() && auth()->user()->type == config('myconfig.privileges.super')))
                    <div class="row justify-content-center">
                    @foreach ($images as $image)
                          <div class="col-md-4 col-4">
                            <a data-fancybox="images" href="{{ config("myconfig.img.url") }}{{ $image->url }}.{{$image->ext}}">
                                <img class="img-fluid" src="{{ config("myconfig.img.url") }}{{ $image->url }}_thumb.jpg" data-was-processed='true'>
                            </a>
                          </div>
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

                {{-- fin card body --}}
                <div class="px-4 mt-2" id="tags">
                    @foreach ($album->tags as $albumtags)
                    <span class="badge badge-danger"><i class="fas fa-tag"></i><span class="badge badge-danger" alt="#{{$albumtags->name}}">{{$albumtags->name}}</span></span>
                    @endforeach
                </div>
                <hr class="bg-dark">
                <div class="mt-2">
                    <div class="sponsor-desktop">
                        <!-- JuicyAds v3.1 -->
                    <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
                    <ins id="960790" data-width="728" data-height="102"></ins>
                    <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':960790});</script>
                    <!--JuicyAds END-->
                    </div>
                    <div class="sponsor-mobile text-center">
                    <!-- JuicyAds v3.1 -->
                    <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
                    <ins id="960824" data-width="300" data-height="112"></ins>
                    <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':960824});</script>
                    <!--JuicyAds END-->
                    </div>
                </div>
                @endif
                </div>
            </div>
            @if ($album->visibility == 1 || $album->user->id == $userId || (Auth::check() && auth()->user()->type == config('myconfig.privileges.super')))
                <div class="mb-4">
                    <livewire:load-more-comment :albumId="$album->id"/>
                </div>
            @endif
        </div>
        @if ($album->visibility == 1 || $album->user->id == $userId || (Auth::check() && auth()->user()->type == config('myconfig.privileges.super')))
        <div class="col-md-4">

                <div class="text-center">
                    <!-- JuicyAds v3.1 -->
                    <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
                    <ins id="960779" data-width="250" data-height="262"></ins>
                    <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':960779});</script>
                    <!--JuicyAds END-->
                                        <!-- JuicyAds v3.1 -->
                    <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
                    <ins id="960779" data-width="250" data-height="262"></ins>
                    <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':960779});</script>
                    <!--JuicyAds END-->
                    <!-- JuicyAds v3.1 -->
                    <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
                    <ins id="960779" data-width="250" data-height="262"></ins>
                    <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':960779});</script>
                    <!--JuicyAds END-->
                </div>

        @endif
    </div>
</div>
<script>
$('[data-fancybox="images"]').fancybox({
  buttons : [
    'slideShow',
    'download',
    'share',
    'thumbs',
    'close'
  ]
});
</script>
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
