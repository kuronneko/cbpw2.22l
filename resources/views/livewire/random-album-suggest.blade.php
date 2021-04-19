<div>
    <div class="card text-white mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><p class="text-danger">Random Album Suggest</p></strong>
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
            <li data-target="#myCarousel" data-slide-to="3"></li>
          </ul>


          <!-- The slideshow -->
          <div class="carousel-inner">
            <div class="carousel-item active">
                @php $count = 0;@endphp
                @foreach ($images as $image)
                @php $count++ @endphp
                @if ($count == 1)
                <div class="image">
                @if (($image->ext == "mp4" || $image->ext == "webm") && ($image->id <= config('myconfig.patch-pre-ffmpeg.image-id-less')))
                <img src="{{'/cbpw2.22l/public/storage/images/videothumb.png'}}" data-was-processed='true'>
                <img src="{{'/cbpw2.22l/public/storage/images/videothumb.png'}}" data-was-processed='true'>
                <img src="{{'/cbpw2.22l/public/storage/images/videothumb.png'}}" data-was-processed='true'>
                @elseif ($image->ext == "mp4" || $image->ext == "webm")
                <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.jpg" data-was-processed='true'>
                <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.jpg" data-was-processed='true'>
                <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.jpg" data-was-processed='true'>
                @else
                <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.{{$image->ext}}"  data-was-processed='true'>
                <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.{{$image->ext}}"  data-was-processed='true'>
                <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.{{$image->ext}}"  data-was-processed='true'>
                @endif
                </div>

                @endif
                @endforeach
            </div>
            <div class="carousel-item">
                @php $count = 0;@endphp
                @foreach ($images as $image)
                @php $count++ @endphp
                @if ($count == 2)
                <div class="image">
                    @if (($image->ext == "mp4" || $image->ext == "webm") && ($image->id <= config('myconfig.patch-pre-ffmpeg.image-id-less')))
                    <img src="{{'/cbpw2.22l/public/storage/images/videothumb.png'}}" data-was-processed='true'>
                    <img src="{{'/cbpw2.22l/public/storage/images/videothumb.png'}}" data-was-processed='true'>
                    <img src="{{'/cbpw2.22l/public/storage/images/videothumb.png'}}" data-was-processed='true'>
                    @elseif ($image->ext == "mp4" || $image->ext == "webm")
                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.jpg" data-was-processed='true'>
                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.jpg" data-was-processed='true'>
                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.jpg" data-was-processed='true'>
                    @else
                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.{{$image->ext}}"  data-was-processed='true'>
                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.{{$image->ext}}"  data-was-processed='true'>
                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.{{$image->ext}}"  data-was-processed='true'>
                    @endif
                </div>

                @endif
                @endforeach
            </div>
            <div class="carousel-item">
                @php $count = 0;@endphp
                @foreach ($images as $image)
                @php $count++ @endphp
                @if ($count == 3)
                <div class="image">
                    @if (($image->ext == "mp4" || $image->ext == "webm") && ($image->id <= config('myconfig.patch-pre-ffmpeg.image-id-less')))
                    <img src="{{'/cbpw2.22l/public/storage/images/videothumb.png'}}" data-was-processed='true'>
                    <img src="{{'/cbpw2.22l/public/storage/images/videothumb.png'}}" data-was-processed='true'>
                    <img src="{{'/cbpw2.22l/public/storage/images/videothumb.png'}}" data-was-processed='true'>
                    @elseif ($image->ext == "mp4" || $image->ext == "webm")
                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.jpg" data-was-processed='true'>
                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.jpg" data-was-processed='true'>
                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.jpg" data-was-processed='true'>
                    @else
                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.{{$image->ext}}"  data-was-processed='true'>
                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.{{$image->ext}}"  data-was-processed='true'>
                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.{{$image->ext}}"  data-was-processed='true'>
                    @endif
                </div>

                @endif
                @endforeach
            </div>
            <div class="carousel-item">
                @php $count = 0;@endphp
                @foreach ($images as $image)
                @php $count++ @endphp
                @if ($count == 4)
                <div class="image">
                    @if (($image->ext == "mp4" || $image->ext == "webm") && ($image->id <= config('myconfig.patch-pre-ffmpeg.image-id-less')))
                    <img src="{{'/cbpw2.22l/public/storage/images/videothumb.png'}}" data-was-processed='true'>
                    <img src="{{'/cbpw2.22l/public/storage/images/videothumb.png'}}" data-was-processed='true'>
                    <img src="{{'/cbpw2.22l/public/storage/images/videothumb.png'}}" data-was-processed='true'>
                    @elseif ($image->ext == "mp4" || $image->ext == "webm")
                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.jpg" data-was-processed='true'>
                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.jpg" data-was-processed='true'>
                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.jpg" data-was-processed='true'>
                    @else
                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.{{$image->ext}}"  data-was-processed='true'>
                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.{{$image->ext}}"  data-was-processed='true'>
                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.{{$image->ext}}"  data-was-processed='true'>
                    @endif
                </div>

                @endif
                @endforeach
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
