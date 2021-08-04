<div>
    <div>
        @if($trigger)
        <div wire:ignore.self class="modal fade" id="createModifyAlbumModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-white ">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    @if ($trigger == "modify")
                    <h4 class="modal-title">Modify Album</h4>
                    @else
                    <h4 class="modal-title">Create new album</h4>
                    @endif
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                  </div>

              <!-- Modal body -->
              <div class="modal-body">
                <form wire:submit.prevent="saveAlbum">
                    @csrf
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" class="form-control" wire:model="name">
                    @error('name') <span class="text-danger"> {{$message}} </span> @enderror
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <input type="text" class="form-control" wire:model="description">
                    @error('description') <span class="text-danger"> {{$message}} </span> @enderror
                </div>
                <div class="form-group">
                    <label for="visibility">Visibility:</label>
                    <select class="form-control" id="visibility" name="visibility" wire:model="visibility">
                          @if ($album)
                          @if ($album->visibility == 1)
                          <option value="1">Visible</option>
                          <option value="0">Private</option>
                              @else
                          <option value="0">Private</option>
                          <option value="1">Visible</option>
                          @endif
                          @else
                          <option value="1">Visible</option>
                          <option value="0">Private</option>
                          @endif
                    </select>
                    @error('visibility') <span class="text-danger"> {{$message}} </span> @enderror
                </div>
                    <div class="mt-4">
                        <button wire:loading.remove type="submit" class="btn btn-danger btn-md"> Guardar</button>
                        <button wire:loading class="btn btn-danger btn-md" disabled><span class="spinner-border spinner-border-sm"></span> Guardar</button>
                    </div>
            </form>
              </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-md" data-dismiss="modal">Cerrar</button>
                  </div>

                </div>
              </div>
            </div>
        @endif
            <script>
                window.addEventListener('show-createModifyAlbumModal', event =>{
                    $('#createModifyAlbumModal').modal('show')
                    });
            </script>
                    <script>
                        window.addEventListener('close-createModifyAlbumModal', event =>{
                            $('#createModifyAlbumModal').modal('hide')
                            });
                    </script>
                @if (session()->has('message'))
                <script>
            swal('{!! Session::get('message')!!}')
                </script>
                @endif
    </div>
</div>
