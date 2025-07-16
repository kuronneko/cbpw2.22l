<div>
    @if (session()->has('message'))
    <script>
      swal('{!! Session::get('message')!!}')
    </script>
    @endif
    <div class="card text-white mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
           <small><span>[User:{{auth()->user()->name}}] Likes</span></small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Like ID</th>
                            <th scope="col">Album owner</th>
                            <th scope="col">Album Name</th>
                            <th scope="col">Dislike</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($likes as $like)
                       <tr>
                            <td>{{$like->id}}</td>
                            <td><img src="{{config('myconfig.img.url')}}{{$like->album->user->avatar}}" class="imgThumb" alt="avatar"></td>
                            <td><strong><a class="text-info" href="{{route('album.content', $like->album->id)}}">{{ $like->album->name }}</a></strong></td>
                            <td><a wire:click="dislike({{$like->album->id}})" role="button" type="button" class="btn btn-danger btn-sm"><i class="fas fa-heart"></i></a></td>
                       </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
            {{$likes->links()}}
        </div>
    </div>
</div>
