@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <small><span>[Album:{{$album->name}}] Comments List</span></small>
                    <a href="{{route('admin.album.index')}}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i></a>
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
                                    <form action="{{route('admin.comment.destroy', $comment->id)}}" method="POST">
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
