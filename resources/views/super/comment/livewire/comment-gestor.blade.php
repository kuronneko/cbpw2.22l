<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <small><span>[Album:{{$album->name}}] Comments List</span></small>
                    <div class="btn-group">
                        <a wire:loading.remove wire:target="$emit('refreshAlbumCleneaded')" wire:click="$emit('refreshAlbumCleneaded')" type="button" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i></a>
                        <a wire:loading wire:target="$emit('refreshAlbumCleneaded')" class="btn btn-dark btn-sm" href="#content"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></a>
                        <a href="{{route('album.content', $album->id)}}" class="btn btn-dark btn-sm"><i class="fas fa-expand-arrows-alt"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    @if ( session('message') )
                    <div class="alert alert-info">{{ session('message') }}</div>
                  @endif
                    <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Options</th>
                            <th scope="col">Name</th>
                            <th scope="col">Text</th>
                            <th scope="col">IP</th>
                            <th scope="col">Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comments as $comment)
                            <tr>
                                <th scope="row">{{ $comment->id }}</th>
                                <td>
                                    <a wire:loading.remove wire:target="deleteComment({{$comment->id}})" wire:click="deleteComment({{$comment->id}})" class="btn btn-danger" role="button" type="button"><i class="fas fa-trash-alt"></i></a>
                                    <a wire:loading wire:target="deleteComment({{$comment->id}})" class="btn btn-danger" href="#content"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></a>
                                </td>
                                <td>{{ $comment->name }}</td>
                                <td>{{ $comment->text }}</td>
                                <td>{{ $comment->ip }}</td>
                                <td>{{ $comment->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                   {{$comments->links()}}
                {{-- fin card body --}}
                </div>
            </div>
        </div>
    </div>
</div>
