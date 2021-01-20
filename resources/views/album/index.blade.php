@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-dark text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>[User:{{auth()->user()->name}}] Album List</span>
                    <a href="{{route('album.create')}}" class="btn btn-secondary btn-sm">New Album</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Created by</th>
                            <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($albums as $album)
                            <tr>
                                <th scope="row">{{ $album->id }}</th>
                                <td>{{ $album->name }}</td>
                                <td>{{ $album->description }}</td>
                                <td>{{ $album->user->name}}</td>
                                <td>
                                    <div class="btn-group">
                                    <a href="{{route('album.showImage', $album->id)}}" class="btn btn-warning" role="button" type="button"><i class="fas fa-eye"></i></a>
                                    <a href="{{route('album.createImage', $album->id)}}" class="btn btn-info" role="button" type="button"><i class="fas fa-plus"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    {{$albums->links()}}
                {{-- fin card body --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
