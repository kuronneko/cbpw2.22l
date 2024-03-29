<div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <small><span>[Album:{{$album->name}}] Image List </span></small>
                    <div class="btn-group">
                        <a wire:loading.remove wire:target="$emit('refreshAlbumCleneaded')" wire:click="$emit('refreshAlbumCleneaded')" type="button" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i></a>
                        <a wire:loading wire:target="$emit('refreshAlbumCleneaded')" class="btn btn-dark btn-sm" href="#content"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></a>
                        <a href="{{route('image.content', $album->id)}}" class="btn btn-dark btn-sm"><i class="fas fa-expand-arrows-alt"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    @if ( session('message') )
                    <div class="alert alert-info">{{ session('message') }}</div>
                  @endif
                    <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Options</th>
                            <th scope="col">URL</th>
                            <th scope="col">Ext</th>
                            <th scope="col">Size</th>
                            <th scope="col">IP</th>
                            <th scope="col">Tags</th>
                            <th scope="col">Created</th>
                            <th scope="col">Basename</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($images as $image)
                            <tr>
                                <th scope="row">{{ $image->id }}</th>
                                <td>
                                    <a wire:loading.remove wire:target="deleteImage({{$image->id}})" wire:click="deleteImage({{$image->id}})" class="btn btn-danger" role="button" type="button"><i class="fas fa-trash-alt"></i></a>
                                    <a wire:loading wire:target="deleteImage({{$image->id}})" class="btn btn-danger" href="#content"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></a>
                                </td>
                                <td>
                                    @if (($image->ext == "mp4" || $image->ext == "webm") && ($image->id <= config('myconfig.patch-pre-ffmpeg.image-id-less')))
                                    <a data-fancybox="images" class="" href="{{ config("myconfig.img.url") }}{{ $image->url }}.{{$image->ext}}"><img src="{{ config("myconfig.img.url") }}{{'/img/videothumb.png'}}" class="imgThumb" data-was-processed='true'></a>
                                    @elseif ($image->ext == "mp4" || $image->ext == "webm")
                                    <a data-fancybox="images" class="" href="{{ config("myconfig.img.url") }}{{ $image->url }}.{{$image->ext}}"><img src="{{ config("myconfig.img.url") }}{{ $image->url }}_thumb.jpg" class="imgThumb" data-was-processed='true'></a>
                                    @else
                                    <a data-fancybox="images" class="" href="{{ config("myconfig.img.url") }}{{ $image->url }}.{{$image->ext}}"><img src="{{ config("myconfig.img.url") }}{{ $image->url }}_thumb.{{$image->ext}}" class="imgThumb" data-was-processed='true'></a>
                                    @endif
                                </td>
                                <td>{{ $image->ext }}</td>
                                <td>{{ app('App\Http\Controllers\admin\ImageController')->formatSizeUnits($image->size) }}</td>
                                <td>{{ $image->ip }}</td>
                                <td>{{ $image->tag }}</td>
                                <td>{{ $image->created_at }}</td>
                                <td>{{ $image->basename }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                   {{$images->links()}}
                {{-- fin card body --}}
                </div>
            </div>
        </div>
    </div>

</div>
