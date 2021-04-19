@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>[Album:{{$album->name}}] Image List </span>
                    <div class="group-buttons">
                        <a href="{{route('admin.album.index')}}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i></a>
                        <a href="{{route('image.content', $album->id)}}" class="btn btn-dark btn-sm"><i class="fas fa-expand-arrows-alt"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    @if ( session('message') )
                    <div class="alert alert-success">{{ session('message') }}</div>
                  @endif
                    <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Options</th>
                            <th scope="col">URL</th>
                            <th scope="col">Ext</th>
                            <th scope="col">Size</th>
                            <th scope="col">IP</th>
                            <th scope="col">Tags</th>
                            <th scope="col">Created</th>
                            <th scope="col">Basename</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($images as $image)
                            <tr>
                                <th scope="row">{{ $image->id }}</th>
                                <td>
                                    <form action="{{route('admin.image.destroy', $image->id)}}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <input type="hidden" name="albumId" id="albumId" value="{{$album->id}}"/>
                                        <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                                <td>
                                    @if (($image->ext == "mp4" || $image->ext == "webm") && ($image->id <= config('myconfig.patch-pre-ffmpeg.image-id-less')))
                                    <a data-fancybox="images" class="" href="{{'/cbpw2.22l/public/'}}{{ $image->url }}.{{$image->ext}}"><img src="{{'/cbpw2.22l/public/storage/images/videothumb.png'}}" class="imgThumb" data-was-processed='true'></a>
                                    @elseif ($image->ext == "mp4" || $image->ext == "webm")
                                    <a data-fancybox="images" class="" href="{{'/cbpw2.22l/public/'}}{{ $image->url }}.{{$image->ext}}"><img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.jpg" class="imgThumb" data-was-processed='true'></a>
                                    @else
                                    <a data-fancybox="images" class="" href="{{'/cbpw2.22l/public/'}}{{ $image->url }}.{{$image->ext}}"><img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.{{$image->ext}}" class="imgThumb" data-was-processed='true'></a>
                                    @endif
                                </td>
                                <td>{{ $image->ext }}</td>
                                <td>{{ app('App\Http\Controllers\admin\ImageController')->formatSizeUnits($image->size) }}</td>
                                <td>{{ $image->ip }}</td>
                                <td>{{ $image->tag }}</td>
                                <td>{{ $image->created_at }}</td>
                                <td>{{ $image->basename }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                   {{$images->links("pagination::bootstrap-4")}}
                {{-- fin card body --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
