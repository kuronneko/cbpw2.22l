<div>
    @if ($foundAlbum->visibility == 1)
    <a wire:click='changeVisibility' class="btn btn-success" role="button" type="button"><i class="fas fa-lock-open"></i></a>
    @else
    <a wire:click='changeVisibility' class="btn btn-dark" role="button" type="button"><i class="fas fa-lock"></i></a>
    @endif
</div>
