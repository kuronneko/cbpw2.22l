<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    @error('photo') <small> <span class="text-danger">{{ $message }}</span></small>
    @enderror
    <div class="avatarContainer">
            <form wire:submit.prevent="store">
                <input type="hidden" value="{{auth()->user()->id}}">
                  @if ($photo)
                 <img src="{{ $photo->temporaryUrl() }}" class="avatar mb-4" alt="">
                 <i class="fas fa-camera avatarIcon btn-file"> <input type="file" wire:model="photo"></i>
                 @else
                 <img src="{{config('myconfig.img.url')}}{{auth()->user()->avatar}}" class="avatar mb-4" alt="">
                 <i class="fas fa-camera avatarIcon btn-file"> <input type="file" wire:model="photo"></i>
                  @endif
                  <div>
                      <button type="submit" class="btn btn-danger btn-file btn-sm" style="position: absolute; left: 20%; top: 30%;">Save</button>
                  </div>
            </form>
            <div>
                <button wire:click="destroy({{auth()->user()->id}})" class="btn btn-danger btn-file btn-sm" style="position: absolute; left: 20%; top: 40%;">Remove</button>
              </div>
    </div>

</div>
