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
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                   <small><span>[Album:{{$album->name}}] Edit</span></small>
                    <a href="{{url('/super/profile?option=albums')}}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i></a>
                </div>
                <div class="card-body">
                    @error('name')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      Name required
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    @enderror @if ($errors->has('description'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      Description required
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    @endif
                    @if ( session('message') )
                    <div class="alert alert-info">{{ session('message') }}</div>
                  @endif
                  <form action="{{route('super.album.update', $album->id)}}" method="POST">
                    @method('PUT')
                    @csrf
                    <input
                      type="text"
                      name="name"
                      maxlength="20"
                      placeholder="Name"
                      value="{{($album->name)}}"
                      class="form-control mb-3"
                    />
                    <input
                    type="text"
                    name="description"
                    maxlength="40"
                    placeholder="Description"
                    value="{{($album->description)}}"
                    class="form-control mb-3"
                  />
@if (Auth::user()->type == config('myconfig.privileges.admin+++') || Auth::user()->type == config('myconfig.privileges.super'))
<select class="form-control" id="visibility" name="visibility">
    @if ($album->visibility == 0)
    <option value="0">Private</option>
    <option value="1">Public</option>
    @else
    <option value="1">Public</option>
    <option value="0">Private</option>
    @endif
  </select>
@else

@endif
                  <br>
                    <button class="btn btn-dark" type="submit">Edit</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
