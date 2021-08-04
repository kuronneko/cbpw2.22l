<div>
    <div>
        @if($album)

        <div wire:ignore.self class="modal fade" id="deleteAlbumModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-white ">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Delete Album?</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">
                    <form wire:submit.prevent="deleteAlbum">
                        @method('DELETE')
                        @csrf
                        <button wire:loading.remove type="submit" class="btn btn-danger btn-md"><i class="fas fa-trash-alt"></i> Permanently delete [{{$album->name}}] with all its content</button>
                        <button wire:loading class="btn btn-danger btn-md" disabled><span class="spinner-border spinner-border-sm"></span> Permanently delete [{{$album->name}}] with all its content</button>
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
                window.addEventListener('show-deleteAlbumModal', event =>{
                    $('#deleteAlbumModal').modal('show')
                    });
            </script>
                    <script>
                        window.addEventListener('close-deleteAlbumModal', event =>{
                            $('#deleteAlbumModal').modal('hide')
                            });
                    </script>
                @if (session()->has('message'))
                <script>
            swal('{!! Session::get('message')!!}')
                </script>
                @endif
    </div>
</div>
