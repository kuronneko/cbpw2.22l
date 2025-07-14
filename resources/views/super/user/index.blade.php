@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <small>Users Gestor</small>
                    <a href="{{url('/super/profile?option=albums')}}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i></a>
                </div>
                    <livewire:super.user-gestor-table />
            </div>
        </div>
    </div>
</div>
<livewire:super.user-gestor/>
@endsection
