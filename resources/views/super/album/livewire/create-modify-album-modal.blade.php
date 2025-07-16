<div>
    <div>
        @if ($trigger)
            <div wire:ignore.self class="modal fade" id="createModifyAlbumModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog">
                    <div class="modal-content text-white ">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            @if ($trigger == 'modify')
                                <h4 class="modal-title">Modify Album</h4>
                            @else
                                <h4 class="modal-title">Create new album</h4>
                            @endif
                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <form wire:submit.prevent="saveAlbum" enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Name:</label>
                                    <input type="text" class="form-control bg-dark text-white border-dark"
                                        wire:model.defer="name">
                                    @error('name')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Description:</label>
                                    <input type="text" class="form-control bg-dark text-white border-dark"
                                        wire:model.defer="description">
                                    @error('description')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="visibility">Visibility:</label>
                                    <select class="form-control bg-dark text-white border-dark" id="visibility"
                                        name="visibility" wire:model.defer="visibility">
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
                                    @error('visibility')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="type">Type:</label>
                                    <select class="form-control bg-dark text-white border-dark" id="type"
                                        name="type" wire:model.defer="type">
                                        @if ($album)
                                            @if ($album->type == config('myconfig.albumType.media') && Auth::check() && Auth::user()->type == 5)
                                                <option value="0">Media</option>
                                                {{--                            <option value="1">EmbedVideo</option> --}}
                                            @else
                                                <option value="0">Media</option>
                                            @endif
                                        @else
                                            <option value="0">Media</option>
                                            @if (Auth::check() && Auth::user()->type == 5)
                                                {{--                       <option value="1">EmbedVideo</option> --}}
                                            @endif
                                        @endif
                                    </select>
                                    @error('type')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                                <script>
                                    document.getElementById("type").onclick = function() {
                                        //embedoptions();
                                        if (document.getElementById('type').value == "1") {
                                            document.getElementById("embed-video-options").classList.remove('d-none');
                                            document.getElementById("embed-video-options").classList.add('d-block');
                                        } else {
                                            document.getElementById("embed-video-options").classList.remove('d-block');
                                            document.getElementById("embed-video-options").classList.add('d-none');
                                        }
                                    };
                                </script>
                                <div wire:ignore id="embed-video-options" class="">
                                    <div class="hr-sect text-white">EmbedVideo Options</div>
                                    <div class="form-group">
                                        <label>URL:</label>
                                        <input type="text" class="form-control" id="url" name="url"
                                            wire:model.defer="url">
                                        @error('url')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="type">Host:</label>
                                        <select class="form-control" id="host" name="host"
                                            wire:model.defer="host">
                                            @if ($embedvideo)
                                                @if ($embedvideo->host == 'steamsb')
                                                    )
                                                    <option value="steamsb">SteamSB</option>
                                                    <option value="youtube">YouTube</option>
                                                @else
                                                    <option value="youtube">YouTube</option>
                                                    <option value="SteamSB">SteamSB</option>
                                                @endif
                                            @else
                                                <option value="steamsb">SteamSB</option>
                                                <option value="youtube">YouTube</option>
                                            @endif
                                        </select>
                                        @error('type')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="custom-file mb-2 mt-3">
                                        <input type="file" id="file" name="file" wire:model.defer="file"
                                            accept="image/*">
                                        @error('file')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button wire:loading.remove type="submit" class="btn btn-danger btn-md">
                                        Guardar</button>
                                    <button wire:loading class="btn btn-danger btn-md" disabled><span
                                            class="spinner-border spinner-border-sm"></span> Guardar</button>
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
            window.addEventListener('show-createModifyAlbumModal', event => {
                $('#createModifyAlbumModal').modal('show')
                if (@this.type == '1') {
                    document.getElementById("embed-video-options").classList.remove('d-none');
                    document.getElementById("embed-video-options").classList.add('d-block');
                } else {
                    document.getElementById("embed-video-options").classList.remove('d-block');
                    document.getElementById("embed-video-options").classList.add('d-none');
                }
            });
        </script>
        <script>
            window.addEventListener('close-createModifyAlbumModal', event => {
                $('#createModifyAlbumModal').modal('hide')
            });
        </script>
        @if (session()->has('message'))
            <script>
                swal('{!! Session::get('message') !!}')
            </script>
        @endif
    </div>
</div>
