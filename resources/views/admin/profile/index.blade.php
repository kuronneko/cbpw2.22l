@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
        <div class="col-md-4 mb-4">
            <div class="card text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <small><span>Profile</span></small>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <livewire:admin.upload-avatar :userId="auth()->user()->id"/>
                    </div>
                        <div>
<small>
    <ul class="list-group">
        <li class="list-group-item">
            <p>Username: {{auth()->user()->name}}</p>
        </li>
        <li class="list-group-item">
            <p>Email: {{auth()->user()->email}}</p>
        </li>
        <li class="list-group-item">
            @if (auth()->user()->type == config('myconfig.privileges.super'))
            <p>Status: Super Admin</p>
            @elseif (auth()->user()->type == config('myconfig.privileges.admin'))
            <p>Status: Normal User</p>
            @elseif (auth()->user()->type == config('myconfig.privileges.admin++'))
            <p>Status: Premium User</p>
            @endif
        </li>
    </ul>
</small>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">

    <div class="alert alert-success alert-dismissible mb-4">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Success!</strong> This alert box could indicate a successful or positive action.
    </div>
    <div class="alert alert-success alert-dismissible mb-4">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Success!</strong> This alert box could indicate a successful or positive action.
    </div>
    <div class="alert alert-success alert-dismissible mb-4">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Success!</strong> This alert box could indicate a successful or positive action.
    </div>
    <div class="alert alert-success alert-dismissible mb-4">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Success!</strong> This alert box could indicate a successful or positive action.
    </div>
    <div class="alert alert-success alert-dismissible mb-4">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Success!</strong> This alert box could indicate a successful or positive action.
    </div>
        </div>
    </div>
    @include('admin.album.show')
</div>
@endsection
