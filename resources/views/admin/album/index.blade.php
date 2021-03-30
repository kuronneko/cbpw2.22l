@extends('layouts.app')

@section('content')
<div class="container publicContainerWithNoPadding">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>[User:{{auth()->user()->name}}] Album List</span>
                    <a href="{{route('admin.album.create')}}" class="btn btn-dark btn-sm">New Album</a>
                </div>
                <div class="card-body">
                    @if ( session('message') )
                    <div class="alert alert-success">{{ session('message') }}</div>
                  @endif
                    <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Options</th>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Admin</th>
                            <th scope="col">Created</th>
                            <th scope="col">Size</th>
                            <th scope="col">View</th>
                            <th scope="col">Visible</th>
                            <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($albums as $album)
                            <?php $albumSize = 0;?>
                            <tr>
                                <td>
                                    <div class="btn-group">
                                    <a href="{{route('admin.image.showImage', $album->id)}}" class="btn btn-warning" role="button" type="button"><i class="fas fa-eye"></i></a>
                                    <a href="{{route('admin.comment.showComment', $album->id)}}" class="btn btn-dark" role="button" type="button"><i class="fas fa-comments"></i></i></a>
                                    <a href="{{route('admin.image.createImage', $album->id)}}" class="btn btn-info" role="button" type="button"><i class="fas fa-plus"></i></a>
                                </div>
                                </td>
                                <th scope="row">{{ $album->id }}</th>
                                <td><strong><a class="text-warning" href="{{route('image.content', $album->id)}}">{{ $album->name }}</a></strong></td>
                                <td>{{ $album->description }}</td>
                                <td>{{ $album->user->name}}</td>
                                <td>{{ $album->created_at}}</td>
                                @foreach ($images as $image)
                                @if (($image->album->id == $album->id) && ($album->user->id == auth()->user()->id))
                                <?php $albumSize = $albumSize + $image->size;?>
                                @endif
                                @endforeach
                                <td>{{ app('App\Http\Controllers\admin\ImageController')->formatSizeUnits($albumSize) }}</td>
                                <td>{{ $album->view}}</td>
                                <td>
                                    <livewire:admin.album-visibility :albumId="$album->id"/>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="#" name="getAlbumData" value="{{ $album->id }}" class="btn btn-danger getAlbumData" id="{{ $album->id }}"><i class="fas fa-trash-alt"></i></a>

                                        <a class="btn btn-info" href="{{route("admin.album.edit", $album->id)}}"><i class="fas fa-edit"></i></a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    {{$albums->links()}}
                {{-- fin card body --}}
                </div>
            </div>
        </div>
    </div>

      <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-white">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Are you sure you want delete this<p id="albumName">AlbumName</p></h4>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <form action="{{route('admin.album.destroy', "deleteAlbum")}}" method="POST" id="deleteAlbum">
                @method('DELETE')
                @csrf
                <input type="hidden" name="albumId" id="albumId" value=""/>
                <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i> Permanently delete album with all its content</button>
            </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function(){
$(document).on('click', '.getAlbumData', function(){
var albumId = $(this).attr("id");
$.ajax({
    headers:{
    'X-CSRF-TOKEN' : "{{csrf_token()}}"
},
url:"{{ route('admin.album.fetchAlbum') }}",
method:"POST",
data:{albumId:albumId},
dataType:"json",
success:function(data){
$('#albumId').val(data.id);
//$('#deleteAlbum').attr('action', controllerPath);
$('#albumName').text('[Album:'+data.name+']');
$('#myModal').modal('show');
}
});
});
});
</script>
@endsection
