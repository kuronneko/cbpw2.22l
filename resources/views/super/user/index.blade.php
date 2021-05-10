@extends('layouts.app')
@section('content')
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Users List</span>
                    <a href="{{route('admin.profile.index')}}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i></a>
                </div>
                <div class="card-body">

                <hr>
                {{-- fin card body --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
