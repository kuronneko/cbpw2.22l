<div>
    <div class="card text-white">
        <div class="card-header d-flex justify-content-between align-items-center">
            <small>Tag Gestor</small>
        </div>
        <div class="card-body">
            @if (session()->has('message'))
            <script>
              swal('{!! Session::get('message')!!}')
            </script>
            @endif
            @include('super.tag.livewire.tag-form')
            <div id="tagsComponent">
                @foreach ($tags as $tag)
                            <button wire:loading.remove wire:target="destroy({{$tag->id}})" wire:click="destroy({{$tag->id}})" class="btn btn-dark btn-sm my-2" value="{{$tag->id}}">
                                 {{$tag->name}} <i class="fas fa-backspace"></i>
                            </button>
                            <button disabled wire:loading wire:target="destroy({{$tag->id}})" class="btn btn-danger btn-sm my-2" value="{{$tag->id}}">
                                 {{$tag->name}} <i class="spinner-border spinner-border-sm"></i>
                            </button>
                @endforeach
            </div>
        </div>
    </div>
</div>

