    @extends('layouts.app')
    @section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card text-white">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Global Tags Settings</span>
                        <a href="{{route('admin.profile.index')}}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i></a>
                    </div>
                    <div class="card-body">
                    <livewire:super.tag-gestor />
                    <hr>
                    {{-- fin card body --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection



