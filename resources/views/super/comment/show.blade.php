@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-transparent border-0 text-white">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-2">
                            <div class="text-center">
                                <livewire:super.upload-avatar :userId="auth()->user()->id"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <small>
                                <ul class="list-group">
                                    <li class="list-group-item bg-transparent border-0">
                                        <p>Username: {{auth()->user()->name}}</p>
                                    </li>
                                    <li class="list-group-item bg-transparent border-0">
                                        <p>Email: {{auth()->user()->email}}</p>
                                    </li>
                                    <li class="list-group-item bg-transparent border-0">
                                        @if (auth()->user()->type == config('myconfig.privileges.super'))
                                        <p class="text-warning">Status: Super Admin</p>
                                        @elseif (auth()->user()->type == config('myconfig.privileges.admin'))
                                        <p class="text-danger">Status: Restrincted User</p>
                                        @elseif (auth()->user()->type == config('myconfig.privileges.admin++'))
                                        <p class="text-info">Status: Premium User</p>
                                        @elseif (auth()->user()->type == config('myconfig.privileges.admin+++'))
                                        <p class="text-success">Status: Premium User+</p>
                                        @elseif (auth()->user()->type == config('myconfig.privileges.user'))
                                        <p class="text-primary">Status: Normal User+</p>
                                        @endif
                                    </li>
                                    <li class="list-group-item bg-transparent border-0">
                                        <p>Last login: {{auth()->user()->last_login_at}}</p>
                                    </li>
                                    <li class="list-group-item bg-transparent border-0">
                                        <p>Last login IP: {{auth()->user()->last_login_ip}}</p>
                                    </li>
                                </ul>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <small><span>[Album:{{$album->name}}] Comments List</span></small>
                    <div class="btn-group">
                        <a href="{{url('/super/profile?option=albums')}}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i></a>
                        <a href="{{route('album.content', $album->id)}}" class="btn btn-dark btn-sm"><i class="fas fa-expand-arrows-alt"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    @if ( session('message') )
                    <div class="alert alert-info">{{ session('message') }}</div>
                  @endif
                    <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Options</th>
                            <th scope="col">Name</th>
                            <th scope="col">Text</th>
                            <th scope="col">IP</th>
                            <th scope="col">Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comments as $comment)
                            <tr>
                                <th scope="row">{{ $comment->id }}</th>
                                <td>
                                    <form action="{{route('super.comment.destroy', $comment->id)}}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <input type="hidden" name="albumId" id="albumId" value="{{$album->id}}"/>
                                        <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                                <td>{{ $comment->name }}</td>
                                <td>{{ $comment->text }}</td>
                                <td>{{ $comment->ip }}</td>
                                <td>{{ $comment->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                   {{$comments->links("pagination::bootstrap-4")}}
                {{-- fin card body --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
