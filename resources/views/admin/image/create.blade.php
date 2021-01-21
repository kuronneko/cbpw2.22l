@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-dark">
                <div class="text-white card-header d-flex justify-content-between align-items-center">
                    <span>[Album:{{$album->name}}] Image Uploader</span>
                    <a href="{{route('admin.album.index')}}" class="btn btn-secondary btn-sm">Back to Albums</a>
                </div>
                <div class="card-body">
                    @if ( session('message') )
                    <div class="alert alert-success">{{ session('message') }}</div>
                  @endif
                    <div class="container" style="padding: 0px;">
                        <div class="form-container">
                            <form action="{{route('admin.image.store')}}" method="POST" class="dropzone" id="mydropzone">
                                <input type="hidden" name="albumId" id="albumId" value="{{$album->id}}"/>
                                <div class="dz-message">
                                    <div class="icon">
                                        <i class="fas fa-cloud-upload-alt uploadIcon"></i>
                                    </div>
                                    <h2>Drag your images here</h2>
                                    <span class="note">Allow files: JPG, PNG, JPEG, MP4, WEBM</span>
                                    <span class="note">Max size: 100mb</span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection