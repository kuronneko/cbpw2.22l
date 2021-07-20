@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <small><span>[Album:{{$album->name}}] Tags List</span></small>
                    <a href="{{route('admin.profile.index')}}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i></a>
                </div>
                <div class="card-body">
                    @if ( session('message') )
                    <div class="alert alert-info">{{ session('message') }}</div>
                  @endif
                    <livewire:admin.attach-tag :albumId="$album->id"/>
                {{-- fin card body --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
