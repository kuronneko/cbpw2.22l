@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-dark">
                <div class="text-white card-header d-flex justify-content-between align-items-center">
                    <span>[Album:{{$album->name}}] Image Uploader</span>
                    <a href="{{route('album.index')}}" class="btn btn-secondary btn-sm">Back to Albums</a>
                </div>
                <div class="card-body">
                    <div class="container" style="padding: 0px;">
                        <div class="form-container">
                            <form action="{{route('image.store')}}" method="POST" class="dropzone" id="mydropzone">
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
<script>
    Dropzone.options.mydropzone = {
        headers:{
            'X-CSRF-TOKEN' : "{{csrf_token()}}"
        },
        //dictDefaultMessage: "Arrastre una imagen al recuadro para subirlo",
        acceptedFiles: "image/*",
        maxFilesize: 100,
        maxFiles: 100,
    };
</script>
@endsection
