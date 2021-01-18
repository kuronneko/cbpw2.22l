@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>[Album:{{$album->name}}] Image List </span>
                    <a href="{{route('album.index')}}" class="btn btn-primary btn-sm">Back to Albums</a>
                </div>
                <div class="card-body">
                    @if ( session('message') )
                    <div class="alert alert-success">{{ session('message') }}</div>
                  @endif
                    <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">URL</th>
                            <th scope="col">Ext</th>
                            <th scope="col">Size</th>
                            <th scope="col">Basename</th>
                            <th scope="col">IP</th>
                            <th scope="col">Tags</th>
                            <th scope="col">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($images as $image)
                            <tr>
                                <th scope="row">{{ $image->id }}</th>
                                <td><img src="/cbpw2.22l/public/{{ $image->url }}thumb.{{$image->ext}}" class="avatar"></td>
                                <td>{{ $image->ext }}</td>
                                <td>{{ $image->size }} KB</td>
                                <td>{{ $image->basename }}</td>
                                <td>{{ $image->ip }}</td>
                                <td>{{ $image->tag }}</td>
                                <td>{{ $image->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    {{$images->links()}}
                {{-- fin card body --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
