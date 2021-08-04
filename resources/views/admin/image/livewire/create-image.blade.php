<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="text-white card-header d-flex justify-content-between align-items-center">
                    <small><span>[Album:{{$album->name}}] Image Uploader</span></small>
                    <div class="btn-group">
                        <a wire:loading.remove wire:target="$emit('refreshAlbumCleneaded')" wire:click="$emit('refreshAlbumCleneaded')" type="button" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i></a>
                        <a wire:loading wire:target="$emit('refreshAlbumCleneaded')" class="btn btn-dark btn-sm" href="#content"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></a>
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
    <script>
        $(document).ready(function(){
            dropzoneStart();

          document.addEventListener("scroll", function(){
            dropzoneStart();
            });
            document.addEventListener("click", function(){
                dropzoneStart();
            });
            document.addEventListener("mouseover", function(){
                dropzoneStart();
             //randomize();
            });
            document.addEventListener("mouseout", function(){
                dropzoneStart();
            });
        });
        </script>
    <script>
        function dropzoneStart(){
            var errors = false;
    Dropzone.options.mydropzone = {
        headers:{
            'X-CSRF-TOKEN' : "{{csrf_token()}}"
        },
        //dictDefaultMessage: "Arrastre una imagen al recuadro para subirlo",
        acceptedFiles: ".png, .jpeg, .jpg, .gif, .mp4, .webm",
        //acceptedFiles: "image/*",
        maxFilesize: 1000,
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
}
</script>

</div>



