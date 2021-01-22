@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-dark text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p>Public Album List</p>
                </div>
                <div class="card-body">
                    <div class="row">
                            @foreach ($albums as $album)
                                <div class="col-12 col-sm-6">
                            <div class="card bg-dark text-white indexCard">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                <p>[Album:{{$album->name}}]</p><p>[User:{{$album->user->name}}]</p>
                                </div>
                                <div class="card-body">
                                    @if ( session('message') )
                                    <div class="alert alert-success">{{ session('message') }}</div>
                                  @endif

                                    <p>Description: {{$album->description}}</p>
                                    <?php $limit = 0; ?>
                                    <div class="photos">
                                    @foreach ($images as $image)

                                    @if($image->album->id == $album->id)
                                    @if($limit != 4)
                                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}thumb.{{$image->ext}}" class="imgThumbPublicIndex masonry" data-was-processed='true'>
                                    <?php $limit++ ?>
                                    @endif
                                    @endif

                                    @endforeach
                                </div>
                                <a href="{{route('image.content', $album->id)}}" class="stretched-link"></a>
                                {{-- fin card body --}}
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
@endsection

