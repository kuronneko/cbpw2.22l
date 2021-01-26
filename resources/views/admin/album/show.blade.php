@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-dark text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>[Album:{{$album->name}}] Image List </span>
                    <a href="{{route('admin.album.index')}}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
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
                            <th scope="col">URL</th>
                            <th scope="col">Ext</th>
                            <th scope="col">Size</th>
                            <th scope="col">IP</th>
                            <th scope="col">Tags</th>
                            <th scope="col">Created at</th>
                            <th scope="col">Options</th>
                            <th scope="col">Basename</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($images as $image)
                            <tr>
                                <th scope="row">{{ $image->id }}</th>
                                <td><a data-fancybox="images" class="" href="{{'/cbpw2.22l/public/'}}{{ $image->url }}"><img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}thumb.{{$image->ext}}" class="imgThumb" data-was-processed='true'></a></td>
                                <td>{{ $image->ext }}</td>
                                <td>{{ $image->size }} Byte</td>
                                <td>{{ $image->ip }}</td>
                                <td>{{ $image->tag }}</td>
                                <td>{{ $image->created_at }}</td>
                                <td>
                                    <form action="{{route('admin.image.destroy', $image->id)}}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <input type="hidden" name="albumId" id="albumId" value="{{$album->id}}"/>
                                        <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
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
