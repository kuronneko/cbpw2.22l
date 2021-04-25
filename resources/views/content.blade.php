@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <livewire:search-dropdown />
            <div class="card text-white mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    @if ($album->visibility == 1 || $album->user->id == $userId || (Auth::check() && auth()->user()->type == 1))
                       @if ($album->visibility == 0)
                    <strong><span class="text-danger">Private Album: {{$album->name}}</span></strong>
                    @if ($album->user->id == $userId || (Auth::check() && auth()->user()->type == 1))
                    <a href="{{route('admin.image.createImage', $album->id)}}" class="btn btn-dark btn-sm" role="button" type="button"><i class="fas fa-plus"></i></a>
                    @endif
                       @else
                    <strong><span class="text-danger upperCaseTittles">Album: {{$album->name}}</span></strong>
                    @if ($album->user->id == $userId || (Auth::check() && auth()->user()->type == 1))
                    <a href="{{route('admin.image.createImage', $album->id)}}" class="btn btn-dark btn-sm" role="button" type="button"><i class="fas fa-plus"></i></a>
                    @endif
                       @endif
                    @else
                        <strong><span>Private Album</span></strong>
                    @endif
                </div>
                <div class="card-body contentCardBodyStyle">
                    <div class="text-center">
                        <img src="{{ config("myconfig.img.url") }}{{'storage/images/loading.gif'}}" class="img-responsive loadingGif">
                    </div>
                    @if ($album->visibility == 1 || $album->user->id == $userId || (Auth::check() && auth()->user()->type == 1))
                    <div class="grid">
                        @foreach ($images as $image)
                        @if (($image->ext == "mp4" || $image->ext == "webm") && ($image->id <= config('myconfig.patch-pre-ffmpeg.image-id-less')))
                        <div class="grid-item" >
                            <a data-fancybox="images" href="{{ config("myconfig.img.url") }}{{ $image->url }}.{{$image->ext}}">
                                <img src="{{ config("myconfig.img.url") }}{{'storage/images/videothumb.png'}}"  data-was-processed='true'>
                             </a>
                           </div>
                        @elseif ($image->ext == "mp4" || $image->ext == "webm")
                        <div class="grid-item" >
                         <a data-fancybox="images" href="{{ config("myconfig.img.url") }}{{ $image->url }}.{{$image->ext}}">
                            <img src="{{ config("myconfig.img.url") }}{{ $image->url }}_thumb.jpg" data-was-processed='true'>
                          </a>
                        </div>
                        @else
                        <div class="grid-item" >
                            <a data-fancybox="images" href="{{ config("myconfig.img.url") }}{{ $image->url }}.{{$image->ext}}">
                                <img src="{{ config("myconfig.img.url") }}{{ $image->url }}_thumb.{{$image->ext}}" data-was-processed='true'></a>
                        </div>
                        @endif
                        @endforeach
                    </div>
                        @else
                        <div class="text-center">
                            <i class="fas fa-lock privateAlbumIcon"></i>
                        <br><br>
                            <p><strong>You cannot access the content of this album.</strong><p>
                        </div>
                        @endif
                    @if ($album->visibility == 1 || $album->user->id == $userId || (Auth::check() && auth()->user()->type == 1))

                    <div class="page-load-status mt-4">
                        <div class="loader-ellips infinite-scroll-request">
                          <span class="loader-ellips__dot"></span>
                          <span class="loader-ellips__dot"></span>
                          <span class="loader-ellips__dot"></span>
                          <span class="loader-ellips__dot"></span>
                        </div>
                      </div>
                      <hr>
                {{-- fin card body --}}
                <div class="px-4 text-center" id="tags">
                    @foreach ($tags as $tag)
                    @foreach ($album->tags as $albumtags)
                        @if($albumtags->pivot->album_id == $album->id && $albumtags->pivot->tag_id == $tag->id)
                           <span class="badge badge-danger"><i class="fas fa-tag"></i><span class="badge badge-danger">{{$tag->name}}</span></span>
                        @endif
                    @endforeach
                 @endforeach
                </div>
                @endif
                </div>

            </div>

        </div>
        @if ($album->visibility == 1 || $album->user->id == $userId || (Auth::check() && auth()->user()->type == 1))
        <div class="col-md-4">
            <div class="card text-white mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong><span class="text-danger">Album details</span></strong>
                </div>
                <div class="card-body contentCardBodyStyleSide">
                    <div>
                        <ul class="list-group">
                        <li class="list-group-item mx-4 text-white customGroupItem upperCaseTittles"><i class="fas fa-book text-white customStatIcons text-center"></i> <strong>{{$album->name}}</strong></li>
                        <li class="list-group-item mx-4 text-white customGroupItem"><i class="fas fa-user text-white customStatIcons text-center"></i> {{$album->user->name}}</li>
                          <li class="list-group-item mx-4 text-white customGroupItem"><i class="fas fa-images text-white customStatIcons text-center"></i> {{$stats['imageCountperAlbum']}}</li>
                          <li class="list-group-item mx-4 text-white customGroupItem"><i class="fas fa-film text-white customStatIcons text-center"></i> {{$stats['videoCountperAlbum']}}</li>
                          <li class="list-group-item mx-4 text-white customGroupItem"><i class="fas fa-comments text-white customStatIcons text-center"></i> {{$stats['commentCountperAlbum']}}</li>
                          <li class="list-group-item mx-4 text-white customGroupItem"><i class="fas fa-eye text-white customStatIcons text-center"></i> {{$stats['viewCountperAlbum']}}</li>
                          <li class="list-group-item mx-4 text-white customGroupItem"><i class="fas fa-hdd text-white customStatIcons text-center"></i> {{$stats['albumSize']}}</li>
                          <li class="list-group-item mx-4 text-white customGroupItem"><i class="fas fa-redo-alt text-white customStatIcons text-center"></i> {{$stats['updated_at']}}</li>
                        </ul>
                      </div>
                </div>
            </div>
            <livewire:random-album-suggest/>
            <div class="card text-white mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong><span class="text-danger">Comments</span></strong>
                    <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#modalComments">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                <div class="card-body contentCardBodyStyleSide">
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="doneMsg" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>
                    <div id="commentBox">
                        @if (count($comments) == 0)
                        <div class="text-center mt-4 mb-4">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p class="text-secondary">No comments found</p>
                        </div>
                        @endif
                        @foreach ($comments as $comment)
                        <div class="row bg-comments mb-1">
                            <div class="col-sm-12">
                                <div class="postNdate">
                                    <p>{{$comment->name}} {{$comment->created_at}} No.<a style="color:#FF3333" href="javascript:quotePost('188')">{{$comment->id}}</a></p>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div>
                                    <p>{{$comment->text}}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
               </div>
       <hr>
    <div>
        <button type="button" class="btn loadBtn btn-block getajaxComments">
            <div class="loader-ellips infinite-scroll-request">
                <span class="loader-ellips__dot"></span>
                <span class="loader-ellips__dot"></span>
                <span class="loader-ellips__dot"></span>
                <span class="loader-ellips__dot"></span>
              </div>
        </button>
        <input type="hidden" id="row" value="">
        <input type="hidden" id="all" value="{{$stats['commentCountperAlbum']}}">
    </div>
        </div>

        @endif
    </div>
</div>

@if ($album->visibility == 1 || $album->user->id == $userId || (Auth::check() && auth()->user()->type == 1))
  <!-- The Modal -->
  <div class="modal fade" id="modalComments">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-white">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Write Post</h4>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorMsg" style="display: none;">
                Name and Text required
            </div>

          <form method="POST" id="commentPost" name="commentPost" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="albumId" id="albumId" value="{{$album->id}}"/>
            @if (Auth::check())
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" maxlength="20" value="{{auth()->user()->name}}" class="form-control mb-3" readonly/>
            </div>
            @else
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" placeholder="Name" maxlength="20" value="{{ old('name') }}" class="form-control mb-3"/>
            </div>
            @endif
            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea class="form-control" rows="3" id="text" name="text" maxlength="150" placeholder="Maximum length: 50 characters" value="{{ old('text') }}"></textarea>
            </div>
            <button class="btn btn-dark" type="submit" id="insert" name="insert"></i> Send</button>
          </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
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
        //columnWidth: 5,
        FitWidth: true,
        percentPosition: true,
        transitionDuration: 0
        });
var gridItemCount = $('.grid-item').length;
if(gridItemCount == 0){
  $(".loadingGif").hide();
  $(".grid").show();
}
$grid.imagesLoaded( function() {
  $(".loadingGif").hide();
  $(".grid").show();
$grid.masonry('layout');
});
   var msnry = $grid.data('masonry');
        var infScroll = new InfiniteScroll( '.grid', {
        path: '?page=@{{#}}',
        append: '.grid-item',
        outlayer: msnry,
        history: false,
        status: '.page-load-status',
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
   var albumId = ($('#albumId').val());
   var permaAll = Number($('#permaAll').val());
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
     reloadComments(albumId);
     //$("#row").val(0);
     getTotalComments(albumId);

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
<script>
    function reloadComments(albumId){
            $.ajax({
                headers:{
    'X-CSRF-TOKEN' : "{{csrf_token()}}"
},
                url:"{{ route('comment.reloadComments') }}",
                method: 'POST',
                data: {albumId:albumId},
                dataType:"json",
                success: function(data) {
                $('#commentBox').html(data.output);
                }
            });
          }
    </script>
    <script>
            function getTotalComments(albumId){
        $.ajax({
            headers:{
    'X-CSRF-TOKEN' : "{{csrf_token()}}"
},
url:"{{ route('comment.getTotalComments') }}",
            method: 'POST',
            data: {albumId:albumId},
            success: function(data) {
            $('#all').val(data.getTotalComments);
            $('#commentCountperAlbum').text(data.getTotalComments);
            }
        });
      }
    </script>
    <script>
        $(document).ready(function(){
    $('.getajaxComments').click(function(){
        var row = Number($('#row').val());
        var allcount = Number($('#all').val());
        var albumId = ($('#albumId').val());
        var rowperpage = 3;
        row = row + rowperpage;
        if(row <= allcount){
            $("#row").val(row);
            $.ajax({
                headers:{
    'X-CSRF-TOKEN' : "{{csrf_token()}}"
},
                url:"{{ route('comment.commentAjaxLoad') }}",
                type: 'post',
                data: {row,albumId:row,albumId},
                beforeSend:function(){
                    //$(".getajaxComments").text("Loading...");
                },
                success: function(response){
                    // Setting little delay while displaying new content
                    setTimeout(function() {
                        // appending posts after last post with class="post"
                        $(".bg-comments:last").after(response.output).show().fadeIn("slow");
                        var rowno = row + rowperpage;
                        // checking row value is greater than allcount or not
                        if(rowno > allcount){
                            // Change the text and background
                            //$('.getajaxComments').text("Hide");
                            //$('.getajaxComments').css("background","darkorchid");
                        }else{
                            //$(".getajaxComments").text("Load more comments");
                        }
                    }, 500);
                }
            });
        }else{
            //$('.getajaxComments').text("Loading...");
            // Setting little delay while removing contents
            setTimeout(function() {
                // When row is greater than allcount then remove all class='post' element after 3 element
                //$('.bg-comments:nth-child(3)').nextAll('.bg-comments').remove();
                reloadComments(albumId);
                // Reset the value of row
                $("#row").val(0);
                // Change the text and background
                             //$('.getajaxComments').text("Load more");
                //$('.getajaxComments').css("background","#15a9ce");
            }, 500);
        }
    });
});

    </script>
@endsection
