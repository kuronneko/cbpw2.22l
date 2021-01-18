@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>[User:{{auth()->user()->name}}] Album List</span>
                    <a href="{{route('album.create')}}" class="btn btn-primary btn-sm">New Album</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Admin</th>
                            <th scope="col">Name</th>
                            <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($albums as $album)
                            <tr>
                                <th scope="row">{{ $album->id }}</th>
                                <td>{{ $album->user->name}}</td>
                                <td>{{ $album->name }}</td>
                                <td><a href="{{route('album.showImage', $album->id)}}" class="btn btn-info" role="button">View</a>
                                    <a href="{{route('album.createImage', $album->id)}}" class="btn btn-info">Add new image</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$albums->links()}}
                {{-- fin card body --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
