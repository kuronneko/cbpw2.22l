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
                    <small><span>[Album:{{$album->name}}] Image List </span></small>
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
                                    <form action="{{route('super.image.destroy', $image->id)}}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <input type="hidden" name="albumId" id="albumId" value="{{$album->id}}"/>
                                        <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                                <td>
                                    @if (($image->ext == "mp4" || $image->ext == "webm") && ($image->id <= config('myconfig.patch-pre-ffmpeg.image-id-less')))
                                    <a data-fancybox="images" class="" href="{{ config("myconfig.img.url") }}{{ $image->url }}.{{$image->ext}}"><img src="{{ config("myconfig.img.url") }}{{'/img/videothumb.png'}}" class="imgThumb" data-was-processed='true'></a>
                                    @elseif ($image->ext == "mp4" || $image->ext == "webm")
                                    <a data-fancybox="images" class="" href="{{ config("myconfig.img.url") }}{{ $image->url }}.{{$image->ext}}"><img src="{{ config("myconfig.img.url") }}{{ $image->url }}_thumb.jpg" class="imgThumb" data-was-processed='true'></a>
                                    @else
                                    <a data-fancybox="images" class="" href="{{ config("myconfig.img.url") }}{{ $image->url }}.{{$image->ext}}"><img src="{{ config("myconfig.img.url") }}{{ $image->url }}_thumb.{{$image->ext}}" class="imgThumb" data-was-processed='true'></a>
                                    @endif
                                </td>
                                <td>{{ $image->ext }}</td>
                                <td>{{ app('App\Services\UtilsService')->formatSizeUnits($image->size) }}</td>
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
