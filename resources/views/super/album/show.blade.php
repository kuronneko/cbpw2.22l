
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <small><span>[User:{{auth()->user()->name}}] Album List</span></small>
                    <a href="{{route('super.album.create')}}" class="btn btn-dark btn-sm">New Album</a>
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
                                    <a href="#" class="btn btn-warning" role="button" type="button"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="btn btn-dark" role="button" type="button"><i class="fas fa-comments"></i></i></a>
                                    <a href="{{route('super.image.createImage', $album->id)}}" class="btn btn-info" ro

                                        le="button" type="button"><i class="fas fa-plus"></i></a>
                                </div>
                                </td>
                                <th scope="row">{{ $album->id }}</th>
                                <td><strong><a class="text-warning" href="{{route('album.content', $album->id)}}">{{ $album->name }}</a></strong></td>
                                <td>{{ $album->description }}</td>
                                <td><strong><a href="#" wire:click.prevent="edit({{$album->user->id}})" class="text-warning">{{ $album->user->name }}</a></strong></td>
                                <td>{{ $album->created_at}}</td>
                                @foreach ($images as $image)
                                @if (($image->album->id == $album->id && $album->user->id == auth()->user()->id) || ($image->album->id == $album->id && auth()->user()->type == 1))
                                <?php $albumSize = $albumSize + $image->size;?>
                                @endif
                                @endforeach
                                <td>{{ app('App\Services\UtilsService')->formatSizeUnits($albumSize) }}</td>
                                <td>{{ $album->stat->view}}</td>
                                <td>
                                    <livewire:super.album-visibility :albumId="$album->id"/>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="#" name="getAlbumData" value="{{ $album->id }}" class="btn btn-danger getAlbumData" id="{{ $album->id }}"><i class="fas fa-trash-alt"></i></a>
                                        <a class="btn btn-info" href="#"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="btn btn-warning" role="button" type="button"><i class="fas fa-tags"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{$albums->links("pagination::bootstrap-4")}}
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
            <form action="{{route('super.album.destroy', "deleteAlbum")}}" method="POST" id="deleteAlbum">
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
  <livewire:super.user-gestor/>

<script>
    window.addEventListener('show-modal', event =>{
        $('#userPreview').modal('show');
    })
</script>
<script>
    $(document).ready(function(){
$(document).on('click', '.getAlbumData', function(){
var albumId = $(this).attr("id");
$.ajax({
    headers:{
    'X-CSRF-TOKEN' : "{{csrf_token()}}"
},
url:"{{ route('super.album.fetchAlbum') }}",
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

