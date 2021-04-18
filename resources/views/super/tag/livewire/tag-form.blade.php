<div class="form-group">
    <div class="input-group">
        <input wire:model.defer="name" type="text" class="form-control text-white searchBarIndex" placeholder="Add new Tag" />

          <div class="input-group-append">
            <button wire:loading.remove wire:click="store" class="btn btn-dark btn-sm rounded"><i class="fas fa-plus"></i></button>
            <button wire:loading wire:target="store" class="btn btn-dark btn-sm rounded"><i class="spinner-border spinner-border-sm"></i></button>
          </div>

      </div>
      @error('name') <span class="text-danger"> {{$message}} </span> @enderror
</div>
<hr>
