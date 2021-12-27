@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-transparent border-0 text-white">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-2">
                            <div class="text-center">
                                <livewire:admin.upload-avatar :userId="auth()->user()->id"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <small>
                                <ul class="list-group">
                                    <li class="list-group-item bg-transparent border-0">
                                        <p>Username: {{auth()->user()->name}}</p>
                                    </li>
                                    <li class="list-group-item bg-transparent border-0">
                                        <p>Email: {{auth()->user()->email}}</p>
                                    </li>
                                    <li class="list-group-item bg-transparent border-0">
                                        @if (auth()->user()->type == config('myconfig.privileges.super'))
                                        <p class="text-warning">Status: Super Admin</p>
                                        @elseif (auth()->user()->type == config('myconfig.privileges.admin'))
                                        <p class="text-danger">Status: Restrincted User</p>
                                        @elseif (auth()->user()->type == config('myconfig.privileges.admin++'))
                                        <p class="text-info">Status: Premium User</p>
                                        @elseif (auth()->user()->type == config('myconfig.privileges.admin+++'))
                                        <p class="text-success">Status: Premium User+</p>
                                        @elseif (auth()->user()->type == config('myconfig.privileges.user'))
                                        <p class="text-primary">Status: Normal User+</p>
                                        @endif
                                    </li>
                                    <li class="list-group-item bg-transparent border-0">
                                        <p>Last login: {{auth()->user()->last_login_at}}</p>
                                    </li>
                                    <li class="list-group-item bg-transparent border-0">
                                        <p>Last login IP: {{auth()->user()->last_login_ip}}</p>
                                    </li>
                                </ul>
                            </small>
                        </div>
                    </div>
                </div>
            </div>



            <div class="card">
                <div class="text-white card-header d-flex justify-content-between align-items-center">
                    <small><span>[Album:{{$album->name}}] Image Uploader</span></small>
                    <div class="btn-group">
                        <a href="{{url('/admin/profile?option=albums')}}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i></a>
                        <a href="{{route('image.content', $album->id)}}" class="btn btn-dark btn-sm"><i class="fas fa-expand-arrows-alt"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    @if ( session('message') )
                    <div class="alert alert-info">{{ session('message') }}</div>
                  @endif
                  <div class="alert alert-success alert-dismissible" id="dropzoneMessageOK" style="display: none">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success!</strong> Images uploaded successfully.
                </div>
                <div class="alert alert-warning alert-dismissible" id="dropzoneMessageProblem" style="display: none">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Warning!</strong> Some images will be not uploaded.
                  </div>
                <div class="text-center">
                    <div class="container-fluid" style="padding: 0px;">
                        <div class="form-container">
                            <form action="{{route('admin.image.store')}}" method="POST" class="dropzone" id="mydropzone">
                                <input type="hidden" name="albumId" id="albumId" value="{{$album->id}}"/>
                                <input type="hidden" name="userId" id="userId" value="{{$album->user->id}}"/>
                                <div class="dz-message">
                                    <div class="icon">
                                        <i class="fas fa-cloud-upload-alt uploadIcon"></i>
                                    </div>
                                    <h2>Drag your images here</h2>
                                    <span class="note">Allow files: JPG, PNG, JPEG, GIF, MP4, WEBM</span>
                                    <span class="note">-> Max size: 1000MB</span>
                                </div>
                            </form>
                        </div>
                     </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var errors = false;
    Dropzone.options.mydropzone = {
        headers:{
            'X-CSRF-TOKEN' : "{{csrf_token()}}"
        },
        //dictDefaultMessage: "Arrastre una imagen al recuadro para subirlo",
        acceptedFiles: ".png, .jpeg, .jpg, .gif, .mp4, .webm",
        //acceptedFiles: "image/*",
        maxFilesize: 20000,
        maxFiles: 100,
        timeout: 0,
        //addRemoveLinks: true,
        init: function (){
    this.on("error", function (file){
        errors = true;
    });
    this.on("queuecomplete", function (file) {
        if(errors) $('#dropzoneMessageProblem').show();
        else $('#dropzoneMessageOK').show();
    });
           /*
    this.on("success", function (file){
        $('#dropzoneMessageOK').show();
    //file_up_names.push(file.name);
    //alert("El archivo se cargó correctamente");
    });
*/
    /*
    this.on("removedfile", function (file){
    $.post('php/controller/adminController.php',
    {file_name:file.name},
    function(data,status){
    //alert(data);
    });
    });
    */
    }
    };
</script>
@endsection
