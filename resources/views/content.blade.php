@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-white mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    @if ($album->visibility == 1)
                        <p class="text-danger">Album: {{$album->name}}</p>
                    @else
                        <p>Private Album</p>
                    @endif
                    <a href="{{route('index')}}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-home"></i>
                    </a>
                </div>
                <div class="card-body">
                    @if ($album->visibility == 1)
                    <div class="grid">
                        @foreach ($images as $image)
                        <a data-fancybox="images" href="{{'/cbpw2.22l/public/'}}{{ $image->url }}.{{$image->ext}}"><img class="grid-item" src="{{'/cbpw2.22l/public/'}}{{ $image->url }}_thumb.{{$image->ext}}" data-was-processed='true'></a>
                        @endforeach
                    </div>
                        @else
                        <div class="text-center">
                            <i class="fas fa-lock privateAlbumIcon"></i>
                        <br><br>
                            <p><strong>You cannot access the content of this album.</strong><p>
                        </div>
                        @endif
                    @if ($album->visibility == 1)
                    <hr>
                    {{$images->links("pagination::bootstrap-4")}}
                {{-- fin card body --}}
                @endif
                </div>
            </div>

        </div>
        @if ($album->visibility == 1)
        <div class="col-md-4">
            <div class="card bg-dark text-white mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p>Album statistics</p>
                </div>
                <div class="card-body">
                    <div>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                                Created by
                                <span class="badge badge-secondary"><i class="fas fa-user"></i><span class="badge badge-secondary">{{$album->user->name}}</span></span>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                                Album name
                                <span class="badge badge-secondary"><i class="fas fa-book"></i><span class="badge badge-secondary">{{$album->name}}</span></span>
                              </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Total Images
                            <span class="badge badge-secondary"><i class="fas fa-images"></i><span class="badge badge-secondary">{{$stats['imageCountperAlbum']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Total Comments
                            <span class="badge badge-secondary"><i class="fas fa-comments"></i></i><span class="badge badge-secondary">{{$stats['commentCountperAlbum']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Total Size
                            <span class="badge badge-secondary"><i class="fas fa-hdd"></i><span class="badge badge-secondary">{{$stats['albumSize']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Last update at
                            <span class="badge badge-secondary"><i class="fas fa-redo-alt"></i><span class="badge badge-secondary">{{$stats['updated_at']}}</span></span>
                          </li>
                        </ul>
                      </div>
                </div>
            </div>
            <div class="card bg-dark text-white mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p>Comments</p>
                    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modalComments">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="doneMsg" style="display: none;">
                        Name and Text required
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>
                    @foreach ($comments as $comment)
                        <p>Name: [{{$comment->name}}] >> Comment: [{{$comment->text}}]</p>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@if ($album->visibility == 1)
  <!-- The Modal -->
  <div class="modal fade" id="modalComments">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-dark text-white">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Write Post</h4>
          <button type="button" class="close bg-dark text-white" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorMsg" style="display: none;">
                Name and Text required
            </div>

          <form method="POST" id="commentPost" name="commentPost" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="albumId" id="albumId" value="{{$album->id}}"/>
            <div class="form-group">
                <label for="usr">Name:</label>
                <input type="text" name="name" id="name" placeholder="Name" value="{{ old('name') }}" class="form-control mb-3"/>
            </div>
            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea class="form-control" rows="3" id="text" name="text" maxlength="150" placeholder="Maximum length: 50 characters" value="{{ old('text') }}"></textarea>
            </div>
            <button class="btn btn-secondary" type="submit" id="insert" name="insert"></i> Send</button>
          </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>
  @endif

<script>
    $(document).ready(function(){
var $grid = $('.grid').masonry({
itemSelector: '.grid-item',
// use element for option
//  columnWidth: '.masonry',
FitWidth: true,
percentPosition: true,
transitionDuration: 0
});
// layout Masonry after each image loads
$grid.imagesLoaded().progress( function() {
$grid.masonry('layout');
});
});
</script>

<script>
    $(document).ready(function(){
 $('#commentPost').on("submit", function(event){
  event.preventDefault();
  if(($('#name').val() == "") || ($('#text').val() == ""))  {
    nameError = "Name and Text required";
    document.getElementById("errorMsg").innerHTML = nameError;
    $('#errorMsg').show();
  }else{
    $("#insert").attr("disabled", true);
   var data = new FormData(this);
   $.ajax({
    headers:{
    'X-CSRF-TOKEN' : "{{csrf_token()}}"
},
    url:"{{ route('comment.store') }}",
    method:"POST",
      data: new FormData( this ),
      processData: false,
      contentType: false,
      dataType:"json",
    beforeSend:function(){
     $('#insert').text("Sending...");
    },
    success:function(data){
     setTimeout(function() {
     $('#modalComments').modal('hide');
     $('#commentPost')[0].reset();
     $('#errorMsg').hide();
     $('#insert').text("Send");
     $("#insert").attr("disabled", false);
     $('#doneMsg').text(data.message);
     $('#doneMsg').show("slow");

     //$("#row").val(0);
     //getTotalComments();
     setTimeout(function() {
    $('#doneMsg').hide("slow");
  }, 5000);

  }, 1000);
    }
   });
  }
 });
});
</script>
@endsection
