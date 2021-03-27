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
    <div class="card-body contentCardBodyStyleSideAlbumSuggest">
         <div class="row" wire:loading.remove>
<div class="col-6 col-sm-7 albumSuggestStatsCol text-white">
<div>
    <span class="badge badge-danger"><i class="fas fa-book"></i>&nbsp;&nbsp;{{$album->name}}&nbsp;&nbsp;</span>
    </div>
    <div>
        <span class="badge badge-dark"><i class="fas fa-images"></i>&nbsp;&nbsp;Images: {{$stats['imageCountperAlbum']}}&nbsp;&nbsp;</span>
    </div>
    <div>
        <span class="badge badge-dark"><i class="fas fa-film"></i>&nbsp;&nbsp;Videos: {{$stats['videoCountperAlbum']}}&nbsp;&nbsp;</span>
            </div>
                <div>
                    <span class="badge badge-dark"><i class="fas fa-comments"></i>&nbsp;&nbsp;Comments: {{$stats['commentCountperAlbum']}}&nbsp;&nbsp;</span>
                    </div>
                    <div>
                        <span class="badge badge-dark"><i class="fas fa-eye"></i>&nbsp;&nbsp;Views: {{$stats['viewCountperAlbum']}}&nbsp;&nbsp;</span>
                        </div>

</div>
<div class="col-6 col-sm-5 albumSuggestImageCol">

<div class="containerAlbumSuggest">
@php $count = 0;@endphp
@foreach ($images as $image)
@if ($count != 2)
<div class="image">
@if ($image->ext == "mp4" || $image->ext == "webm")
<img src="{{'/cbpw2.22l/public/storage/images/videothumb.png'}}" data-was-processed='true'>
@else
<img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.{{$image->ext}}"  data-was-processed='true'>
@endif
</div>
@php $count++ @endphp
@endif
@endforeach
  </div>
  <div class="containerAlbumSuggest">
    @php $count = 0;@endphp
    @foreach ($images as $image)
    @php $count++ @endphp
    @if ($count > 2)
    <div class="image">
        @if ($image->ext == "mp4" || $image->ext == "webm")
        <img src="{{'/cbpw2.22l/public/storage/images/videothumb.png'}}" data-was-processed='true'>
        @else
        <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.{{$image->ext}}"  data-was-processed='true'>
        @endif
    </div>
    @endif
    @endforeach
          </div>

</div>
         </div>
    </div>
</a>
</div>
@endif


</div>
