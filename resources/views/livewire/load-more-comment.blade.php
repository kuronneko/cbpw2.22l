<div>
    @if (session()->has('message'))
    <script>
swal('{!! Session::get('message')!!}')
    </script>
    @endif
    <div id="formBox">
        @include('livewire.comment-form')
    </div>

    <div class="row mt-5">
        <div class="col-1 col-md-1">

        </div>
        <div class="col-11 col-md-11">
        <div id="comments">
            @foreach ($comments as $comment)
            <div class="row bg-comments mb-1">

                <div class="col-sm-12">
                    <div class="postNdate">
                        <p>{{$comment->name}} {{$comment->created_at}} No.<a style="color:#FF3333" href="javascript:quotePost('188')">{{$comment->id}}</a></p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="float-left mr-4">
                        <img src="{{config('myconfig.img.url')}}{{$comment->user->avatar}}" class="avatarComment" alt="avatar">
                    </div>
                    <div>
                        <p>{{$comment->text}}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if ($commentCheck == 'maxComments')
        <button wire:click='hidden' wire:loading.remove class="btn loadBtn btn-sm btn-block text-white mb-2">
            Hidden
        </button>
        @elseif ($commentCheck == 'minComments')

        @else
        <button wire:click='load' wire:loading.remove class="btn loadBtn btn-sm btn-block text-white mb-2">
            Load more
        </button>
        @endif
        <button wire:loading wire:target="load" class="btn loadBtn btn-sm btn-block mb-2">
            <div class="page-load-status">
                <div class="loader-ellips infinite-scroll-request">
                  <span class="loader-ellips__dot"></span>
                  <span class="loader-ellips__dot"></span>
                  <span class="loader-ellips__dot"></span>
                  <span class="loader-ellips__dot"></span>
                </div>
              </div>
        </button>
        </div>
    </div>

</div>
