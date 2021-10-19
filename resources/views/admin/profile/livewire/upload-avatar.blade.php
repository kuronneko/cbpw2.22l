<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    @if (session()->has('message'))
    <script>
swal('{!! Session::get('message')!!}')
    </script>
    @endif
    <div class="avatarContainer">
            <form wire:submit.prevent="store">
                <input type="hidden" value="{{$user->id}}">
                  @if ($photo)
                 <img src="{{ $photo->temporaryUrl() }}" class="avatar mb-4" alt="">
                 <i class="fas fa-camera avatarIcon btn-file"> <input type="file" wire:model="photo"  accept="image/*"></i>
                 @else
                 <img src="{{config('myconfig.img.url')}}{{$user->avatar}}" class="avatar mb-4" alt="">
                 <i class="fas fa-camera avatarIcon btn-file"> <input type="file" wire:model="photo"  accept="image/*"></i>
                  @endif
                  <div>
                      <button  wire:loading.remove type="submit" id="addBtn" name="addBtn" class="btn btn-danger btn-sm btn-save" >Save </button>
                      <button  wire:loading type="submit" id="addBtn" name="addBtn" class="btn btn-danger btn-file btn-sm btn-save" disabled><span class="spinner-border spinner-border-sm"></span></button>
                  </div>
            </form>
            <form wire:submit.prevent="destroy">
                <div>
                    <button  wire:loading.remove wire:target="destroy" wire:click="destroy" id="removeBtn" name="removeBtn" type="submit" class="btn btn-danger btn-remove btn-sm">Remove </button>
                    <button  wire:loading wire:target="destroy" id="removeBtn" name="removeBtn" type="submit" class="btn btn-danger btn-remove btn-sm disabled"><span class="spinner-border spinner-border-sm"></span></button>
                </div>
            </form>
    </div>

</div>
