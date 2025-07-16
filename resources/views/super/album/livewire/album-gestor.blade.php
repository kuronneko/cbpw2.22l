<div>
@if ($subOptionId && $subOption == "showImageGestor")
<livewire:super.image-gestor :albumId="$subOptionId"/>
@elseif ($subOptionId && $subOption == "showCommentGestor")
<livewire:super.comment-gestor :albumId="$subOptionId"/>
@elseif ($subOptionId && $subOption == "showCreateImage")
<livewire:super.image-gestor :albumId="$subOptionId" :createImage="true"/>
@elseif ($subOptionId && $subOption == "showTagGestorAtt")
<livewire:super.attach-tag :albumId="$subOptionId"/>
    @else
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <small><span>[User:{{auth()->user()->name}}] Album List</span></small>
                    <a wire:loading.remove wire:target="createAlbumModal" wire:click="createAlbumModal" class="btn btn-dark btn-sm" role="button" type="button"> New Album</a>
                    <a wire:loading wire:target="createAlbumModal" class="btn btn-dark btn-sm" href="#content"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i> New Album</a>
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
                            <th scope="col">Type</th>
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
                                    <a wire:loading.remove wire:target="showImageGestor({{$album->id}})" wire:click="showImageGestor({{$album->id}})" class="btn btn-warning" role="button" type="button"><i class="fas fa-eye"></i></a>
                                    <a wire:loading wire:target="showImageGestor({{$album->id}})" class="btn btn-warning" href="#content"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></a>

                                    <a wire:loading.remove wire:target="showCommentGestor({{$album->id}})" wire:click="showCommentGestor({{$album->id}})" class="btn btn-dark" role="button" type="button"><i class="fas fa-comments"></i></a>
                                    <a wire:loading wire:target="showCommentGestor({{$album->id}})" class="btn btn-dark" href="#content"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></a>

                                    <a href="{{route('super.image.createImage', $album->id)}}" class="btn btn-info" role="button" type="button"><i class="fas fa-plus"></i></a>

                                </div>
                                </td>
                                <th scope="row">{{ $album->id }}</th>
                                <td><strong><a class="text-info" href="{{route('album.content', $album->id)}}">{{ $album->name }}</a></strong></td>
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
                                @foreach ($stats as $stat)
                                @if (($stat->album->id == $album->id && $album->user->id == auth()->user()->id) || ($stat->album->id == $album->id && auth()->user()->type == config('myconfig.privileges.super')))
                                <td>{{ app('App\Services\UtilsService')->formatSizeUnits($stat->size) }}</td>
                                <td>{{ $stat->view}}</td>
                                @endif
                                @endforeach
                                <td>
                                    @if ($album->type == config('myconfig.albumType.embedvideo'))
                                        <span><i class="fas fa-link"></i></span>
                                        @elseif($album->type == config('myconfig.albumType.media'))
                                        <span><i class="fas fa-images"></i></span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        @if ($album->visibility == 1)
                                        <a wire:loading.remove wire:target='changeVisibility({{$album->id}})' wire:click='changeVisibility({{$album->id}})' class="btn btn-success" role="button" type="button"><i class="fas fa-lock-open"></i></a>
                                        <a wire:loading wire:target='changeVisibility({{$album->id}})' class="btn btn-success" role="button" type="button"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></a>
                                        @else
                                        <a  wire:loading.remove wire:target='changeVisibility({{$album->id}})' wire:click='changeVisibility({{$album->id}})' class="btn btn-dark" role="button" type="button"><i class="fas fa-lock"></i></a>
                                        <a wire:loading wire:target='changeVisibility({{$album->id}})' class="btn btn-dark" role="button" type="button"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a wire:loading.remove wire:target="deleteAlbumModal({{$album->id}})" wire:click="deleteAlbumModal({{$album->id}})" class="btn btn-danger" role="button" type="button"><i class="fas fa-trash-alt"></i></a>
                                        <a wire:loading wire:target="deleteAlbumModal({{$album->id}})" class="btn btn-danger" href="#content"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></a>

                                        <a wire:loading.remove wire:target="modifyAlbumModal({{$album->id}})" wire:click="modifyAlbumModal({{$album->id}})" class="btn btn-info" role="button" type="button"><i class="fas fa-edit"></i></a>
                                        <a wire:loading wire:target="modifyAlbumModal({{$album->id}})" class="btn btn-info" href="#content"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></a>

                                        <a wire:loading.remove wire:target="showTagGestorAtt({{$album->id}})" wire:click="showTagGestorAtt({{$album->id}})" class="btn btn-warning" role="button" type="button"><i class="fas fa-tags"></i></a>
                                        <a wire:loading wire:target="showTagGestorAtt({{$album->id}})" class="btn btn-warning" href="#content"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></a>
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

  <livewire:super.delete-album-modal/>
  <livewire:super.create-modify-album-modal/>
  @if(Auth::user()->type == config('myconfig.privileges.super'))
  <livewire:super.user-gestor/>
  @endif
  @push('scripts')
  <script>
      Livewire.restart();
  </script>
@endpush

@endif

</div>
