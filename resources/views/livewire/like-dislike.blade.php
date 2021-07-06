<div>
    @if (session()->has('message'))
    <script>
      swal('{!! Session::get('message')!!}')
    </script>
    @endif

    @if ($userSessionId)

    @if ($like)
    @if (($userSessionId == $like->user->id) && ($album->id == $like->album->id) && ($like->status == 1))
    <a wire:click="dislike" role="button" type="button" class="btn btn-danger btn-sm"><i class="fas fa-heart"> {{$totalLikes}}</i></a>
    @endif
    @else
    <a wire:click="like" role="button" type="button" class="btn btn-danger btn-sm"><i class="far fa-heart"> {{$totalLikes}}</i></a>
    @endif

    @else
    <a wire:click="like" role="button" type="button" class="btn btn-danger btn-sm"><i class="fas fa-heart"> {{$totalLikes}}</i></a>
    @endif
</div>
