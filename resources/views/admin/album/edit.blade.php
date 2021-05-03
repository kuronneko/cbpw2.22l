@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                   <small><span>[Album:{{$album->name}}] Edit</span></small>
                    <a href="{{route('admin.profile.index')}}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i></a>
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
                  <form action="{{route('admin.album.update', $album->id)}}" method="POST">
                    @method('PUT')
                    @csrf
                    <input
                      type="text"
                      name="name"
                      placeholder="Name"
                      value="{{($album->name)}}"
                      class="form-control mb-3"
                    />
                    <input
                    type="text"
                    name="description"
                    placeholder="Description"
                    value="{{($album->description)}}"
                    class="form-control mb-3"
                  />
                  <select class="form-control" id="visibility" name="visibility">
                    @if ($album->visibility == 0)
                    <option value="0">Private</option>
                    <option value="1">Public</option>
                    @else
                    <option value="1">Public</option>
                    <option value="0">Private</option>
                    @endif
                  </select>
                  <br>
                    <button class="btn btn-dark" type="submit">Edit</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
