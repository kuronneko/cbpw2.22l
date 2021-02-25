@extends('layouts.app')

@section('content')
<div class="container publicContainerWithNoPadding">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>New Album</span>
                    <a href="{{route('admin.album.index')}}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i></a>
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
                    <div class="alert alert-success">{{ session('message') }}</div>
                  @endif
                  <form method="POST" action="{{route('admin.album.store')}}">
                    @csrf
                    <input
                      type="text"
                      name="name"
                      placeholder="Name"
                      value="{{ old('name') }}"
                      class="form-control mb-3"
                    />
                    <input
                    type="text"
                    name="description"
                    placeholder="Description"
                    value="{{ old('description') }}"
                    class="form-control mb-3"
                  />
                  <select class="form-control" id="visibility" name="visibility">
                    <option value="1">Public</option>
                    <option value="0">Private</option>
                  </select>
                  <br>
                    <button class="btn btn-dark" type="submit">Create</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
