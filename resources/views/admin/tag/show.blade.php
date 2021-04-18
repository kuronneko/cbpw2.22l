@extends('layouts.app')
@section('content')
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p>[Album:{{$album->name}}] Tags List</p>
                </div>
                <div class="card-body">
                    <livewire:admin.attach-tag :albumId="$album->id"/>
                {{-- fin card body --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
