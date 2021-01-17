@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Add Album</span>
                    <a href="{{route('album.index')}}" class="btn btn-primary btn-sm">Back to Albums</a>
                </div>
                <div class="card-body">
                  @if ( session('message') )
                    <div class="alert alert-success">{{ session('message') }}</div>
                  @endif
                  <form method="POST" action="{{route('album.store')}}">
                    @csrf
                    <input
                      type="text"
                      name="name"
                      placeholder="Name"
                      class="form-control mb-2"
                    />
                    <button class="btn btn-primary btn-block" type="submit">Add</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
