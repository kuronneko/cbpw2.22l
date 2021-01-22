@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-dark text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p>[Album:{{$album->name}}] Content</p>
                </div>
                <div class="card-body">
                    <div class="photos">
                        @foreach ($images->reverse() as $image)
                        <a data-fancybox="images" href="{{'/cbpw2.22l/public/'}}{{ $image->url }}"><img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}thumb.{{$image->ext}}" class="img-fluid masonry imgThumbPublicContent" data-was-processed='true'></a>
                        @endforeach
                    </div>
                    {{$images->links("pagination::bootstrap-4")}}
                {{-- fin card body --}}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
