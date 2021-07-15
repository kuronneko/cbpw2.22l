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
                                <li class="list-group-item">
                                    <p>Last login: {{auth()->user()->last_login_at}}</p>
                                </li>
                                <li class="list-group-item">
                                    <p>Last login IP: {{auth()->user()->last_login_ip}}</p>
                                </li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 mb-4">
                <livewire:admin.user-menu/>
        </div>
    </div>


</div>
@endsection
