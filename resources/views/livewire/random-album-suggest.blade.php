<div>
    <div class="card text-white mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><span class="text-danger">Random Album Suggest</span></strong>
            <a wire:click='render' wire:loading.remove class="btn btn-dark btn-sm">
                <i class="fas fa-dice"></i>
            </a>
            <a wire:loading class="btn btn-dark btn-sm disabled">
                <span class="spinner-border spinner-border-sm"></span>
            </a>
        </div>
        <div wire:loading>
            <br><br>
            <div class="loader-ellips infinite-scroll-request">
                <span class="loader-ellips__dot"></span>
                <span class="loader-ellips__dot"></span>
                <span class="loader-ellips__dot"></span>
                <span class="loader-ellips__dot"></span>
              </div>
              <br><br>
        </div>
@if ($empty == 0)
<div wire:loading.remove class="text-center mt-4 mb-4">
    <i class="fas fa-exclamation-triangle"></i>
    <p class="text-secondary">No album suggestion found</p>
</div>
@else
<a href="{{route('image.content', $album->id)}}" class="personalizeA">

    <div wire:loading.remove class="container mt-3 text-center">

        <div id="myCarousel" class="carousel slide" data-ride="carousel">

          <!-- Indicators -->
          <ul class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
          </ul>


          <!-- The slideshow -->
          <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="image">
                @foreach ($images as $i => $image)
                    @if ($i < 3)
                @if (($image->ext == "mp4" || $image->ext == "webm") && ($image->id <= config('myconfig.patch-pre-ffmpeg.image-id-less')))
                <img src="{{config("myconfig.img.url")}}{{'storage/images/videothumb.png'}}" data-was-processed='true'>
                @elseif ($image->ext == "mp4" || $image->ext == "webm")
                <img src="{{config("myconfig.img.url")}}{{ $image->url }}_thumb.jpg" data-was-processed='true'>
                @else
                <img src="{{config("myconfig.img.url")}}{{ $image->url }}_thumb.{{$image->ext}}"  data-was-processed='true'>
                @endif
                @endif
                @endforeach
            </div>
            </div>
            <div class="carousel-item">
                <div class="image">
                    @foreach ($images2 as $i => $image)
                        @if ($i < 3)
                    @if (($image->ext == "mp4" || $image->ext == "webm") && ($image->id <= config('myconfig.patch-pre-ffmpeg.image-id-less')))
                    <img src="{{config("myconfig.img.url")}}{{'storage/images/videothumb.png'}}" data-was-processed='true'>
                    @elseif ($image->ext == "mp4" || $image->ext == "webm")
                    <img src="{{config("myconfig.img.url")}}{{ $image->url }}_thumb.jpg" data-was-processed='true'>
                    @else
                    <img src="{{config("myconfig.img.url")}}{{ $image->url }}_thumb.{{$image->ext}}"  data-was-processed='true'>
                    @endif
                    @endif
                    @endforeach
                </div>
            </div>
            <div class="carousel-item">
                <div class="image">
                    @foreach ($images3 as $i => $image)
                    @if ($i < 3)
                    @if (($image->ext == "mp4" || $image->ext == "webm") && ($image->id <= config('myconfig.patch-pre-ffmpeg.image-id-less')))
                    <img src="{{config("myconfig.img.url")}}{{'storage/images/videothumb.png'}}" data-was-processed='true'>
                    @elseif ($image->ext == "mp4" || $image->ext == "webm")
                    <img src="{{config("myconfig.img.url")}}{{ $image->url }}_thumb.jpg" data-was-processed='true'>
                    @else
                    <img src="{{config("myconfig.img.url")}}{{ $image->url }}_thumb.{{$image->ext}}"  data-was-processed='true'>
                    @endif
                    @endif
                    @endforeach
                </div>
            </div>
          </div>

          <!-- Left and right controls -->
          <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </a>
          <a class="carousel-control-next" href="#myCarousel" data-slide="next">
            <span class="carousel-control-next-icon"></span>
          </a>
        </div>

        </div>

</a>
</div>
@endif


</div>
