@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-dark text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p>Public Album List</p>
                </div>
                <div class="card-body">
                    <div class="row">
                            @foreach ($albums as $album)
                            <?php $imageLimitperAlbum = 0;$imageCountperAlbum = 0;$updated_at = "";$albumSize = 0;?>
                                <div class="col-12 col-sm-6">
                            <div class="card bg-dark text-white indexCard">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                <p class="cardAlbumTittle">[Album:{{$album->name}}]</p><p class="cardAlbumTittle">[User:{{$album->user->name}}]</p>
                                </div>
                                <div class="card-body">
                                    @if ( session('message') )
                                    <div class="alert alert-success">{{ session('message') }}</div>
                                  @endif
                                    <p class="cardAlbumDescription">Description: {{$album->description}}</p>
                                <div class="photos">
                                    @foreach ($images as $image)
                                    @if($image->album->id == $album->id)
                                    <?php $albumSize = $albumSize + $image->size;?>
                                    @if ($imageCountperAlbum == 0)
                                    <?php $updated_at = $image->updated_at?>
                                    @endif
                                    <?php $imageCountperAlbum++ ?>
                                    @if($imageLimitperAlbum != 4)
                                    <img src="{{'/cbpw2.22l/public/'}}{{ $image->url }}thumb.{{$image->ext}}" class="imgThumbPublicIndex masonry" data-was-processed='true'>
                                    <?php $imageLimitperAlbum++ ?>
                                    @endif
                                    @endif
                                    @endforeach
                                </div>
                                {{-- fin card body --}}
                                </div>
                                <div class="card-footer">
                                    <span class="badge badge-secondary"><i class="fas fa-images"></i><span class="badge badge-secondary"><?php echo $imageCountperAlbum?></span></span>
                                    <span class="badge badge-secondary"><i class="fas fa-redo-alt"></i><span class="badge badge-secondary"><?php echo $updated_at?></span></span>
                                    <span class="badge badge-secondary"><i class="fas fa-hdd"></i><span class="badge badge-secondary"><?php echo app('App\Http\Controllers\PublicImageController')->formatSizeUnits($albumSize)?></span></span>
                                    <a href="{{route('image.content', $album->id)}}" class="stretched-link"></a>
                                </div>
                            </div>
                            <br>
                        </div>
                            @endforeach
                        </div>
                        {{$albums->links("pagination::bootstrap-4")}}
                {{-- fin card body --}}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

