@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-dark text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    @if ($album->visibility == 1)
                        <p>[Album:{{$album->name}}] Content</p>
                    @else
                        <p>Private Album</p>
                    @endif
                    <a href="{{route('index')}}" class="btn btn-secondary btn-sm">Back to Public Albums</a>
                </div>
                <div class="card-body">
                    <?php $imageCountperAlbum = 0;$updated_at = "";$albumSize = 0;?>
                    @if ($album->visibility == 1)
                    @foreach ($images->reverse() as $image)
                    @if($image->album->id == $album->id)
                    @if ($imageCountperAlbum == 0)
                    <?php $updated_at = $image->updated_at?>
                    @endif
                    <?php $imageCountperAlbum++ ?>
                    <?php $albumSize = $albumSize + $image->size;?>
                    @endif
                    @endforeach
                    <div class="alert badge-secondary alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <span class="badge badge-dark"><i class="fas fa-images"></i><span class="badge badge-dark"><?php echo $imageCountperAlbum?></span></span>
                    <span class="badge badge-dark"><i class="fas fa-redo-alt"></i><span class="badge badge-dark"><?php echo $updated_at?></span></span>
                    <span class="badge badge-dark"><i class="fas fa-hdd"></i><span class="badge badge-dark"><?php echo app('App\Http\Controllers\PublicImageController')->formatSizeUnits($albumSize)?></span></span>
                    </div>

                    <div class="photos">
                        @foreach ($images->reverse() as $image)
                        <a data-fancybox="images" href="{{'/cbpw2.22l/public/'}}{{ $image->url }}"><img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}thumb.{{$image->ext}}" class="img-fluid masonry imgThumbPublicContent" data-was-processed='true'></a>
                        @endforeach
                        @else
                        <div class="text-center">
                            <i class="fas fa-lock privateAlbumIcon"></i>
                        <br><br>
                            <p><strong>You cannot access the content of this album.</strong><p>
                        </div>
                        @endif
                    </div>
                    {{$images->links("pagination::bootstrap-4")}}
                {{-- fin card body --}}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
