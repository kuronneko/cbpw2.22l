<div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <small><span>[User:{{auth()->user()->name}}] Album List</span></small>
                    <a href="{{route('admin.album.create')}}" class="btn btn-dark btn-sm">New Album</a>
                </div>
                <div class="card-body">
                    @if ( session('message') )
                    <div class="alert alert-info">{{ session('message') }}</div>
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
                                    <a href="{{route('admin.image.createImage', $album->id)}}" class="btn btn-info" ro

                                        le="button" type="button"><i class="fas fa-plus"></i></a>
                                </div>
                                </td>
                                <th scope="row">{{ $album->id }}</th>
                                <td><strong><a class="text-info" href="{{route('image.content', $album->id)}}">{{ $album->name }}</a></strong></td>
                                <td>{{ $album->description }}</td>
                                <td>
                                        @if(Auth::user()->type == config('myconfig.privileges.super'))
                                        @if ($album->user->type == config('myconfig.privileges.super'))
                                        <strong><a href="#" wire:click.prevent="userEdit({{$album->user->id}})" class="text-warning"><small>[S] </small>{{ $album->user->name }}</a></strong>
                                        @elseif ($album->user->type == config('myconfig.privileges.admin'))
                                        <strong><a href="#" wire:click.prevent="userEdit({{$album->user->id}})" class="text-danger"><small>[R] </small>{{ $album->user->name }}</a></strong>
                                        @elseif ($album->user->type == config('myconfig.privileges.admin++'))
                                        <strong><a href="#" wire:click.prevent="userEdit({{$album->user->id}})" class="text-info"><small>[P] </small>{{ $album->user->name }}</a></strong>
                                        @elseif ($album->user->type == config('myconfig.privileges.admin+++'))
                                        <strong><a href="#" wire:click.prevent="userEdit({{$album->user->id}})" class="text-success"><small>[P+] </small>{{ $album->user->name }}</a></strong>
                                        @endif
                                        @else

                                        @if ($album->user->type == config('myconfig.privileges.admin'))
                                        <strong><p class="text-danger"><small>[R] </small>{{ $album->user->name }}</p></strong>
                                        @elseif ($album->user->type == config('myconfig.privileges.admin++'))
                                        <strong><p class="text-info"><small>[P] </small>{{ $album->user->name }}</p></strong>
                                        @elseif ($album->user->type == config('myconfig.privileges.admin+++'))
                                        <strong><p class="text-success"><small>[P+] </small>{{ $album->user->name }}</p></strong>
                                        @endif

                                        @endif
                                </td>
                                <td>{{ $album->created_at}}</td>
                                @foreach ($images as $image)
                                @if (($image->album->id == $album->id && $album->user->id == auth()->user()->id) || ($image->album->id == $album->id && auth()->user()->type == config('myconfig.privileges.super')))
                                <?php $albumSize = $albumSize + $image->size;?>
                                @endif
                                @endforeach
                                <td>{{ app('App\Http\Controllers\admin\ImageController')->formatSizeUnits($albumSize) }}</td>
                                <td>{{ $album->view}}</td>
                                <td>
                                    <div>
                                        @if ($album->visibility == 1)
                                        <a wire:click='changeVisibility({{$album->id}})' class="btn btn-success" role="button" type="button"><i class="fas fa-lock-open"></i></a>
                                        @else
                                        <a wire:click='changeVisibility({{$album->id}})' class="btn btn-dark" role="button" type="button"><i class="fas fa-lock"></i></a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="#" name="getAlbumData" value="{{ $album->id }}" class="btn btn-danger getAlbumData" id="{{ $album->id }}"><i class="fas fa-trash-alt"></i></a>
                                        <a class="btn btn-info" href="{{route("admin.album.edit", $album->id)}}"><i class="fas fa-edit"></i></a>
                                        <a href="{{route('admin.tag.showTag', $album->id)}}" class="btn btn-warning" role="button" type="button"><i class="fas fa-tags"></i></a>
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
  <livewire:super.user-gestor/>
  @push('scripts')
  <script>
      Livewire.restart();
  </script>
@endpush
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

</div>
