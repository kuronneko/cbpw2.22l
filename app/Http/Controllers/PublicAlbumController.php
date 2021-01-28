<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PublicAlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::all()->sortByDesc("id");
        $albums = Album::where('visibility', 1)->orderBy('updated_at','desc')->paginate(6);
//fail test of bump albums    $albums = Album::where('visibility', 1)->whereHas('images', 'albums.id', '=', 'images.album_id')->orderBy('images.updated_at', 'desc')->paginate(5);
//SELECT DISTINCT ALBUMS.name from albums, images WHERE (albums.visibility=1) AND (albums.id=images.album_id) ORDER BY (images.updated_at) DESC
        $albumsFull = Album::where('visibility', 1)->orderBy('updated_at','desc')->get();
        $totalPublicAlbums = 0;$totalPublicImages = 0;$totalAlbumSize = 0;$lastImageUploaded = "";
        foreach ($albumsFull as $album) {
            foreach ($images as $image) {
                if($image->album->id == $album->id){
                   $totalAlbumSize = $totalAlbumSize + $image->size;
                   if($totalPublicAlbums == 0){
                      $lastUpdateAlbum = $album->updated_at;
                   }
                   $totalPublicImages++;
                }
            }
            $totalPublicAlbums++;
        }
        //$lastImageUploaded = app('App\Http\Controllers\PublicImageController')->searchImageById($max)->updated_at; //deprecated method using algoritm who obtain the max number id asuming that is the last image uploaded
        $stats = array(
            'totalPublicAlbums' => $totalPublicAlbums,
            'totalPublicImages' => $totalPublicImages,
            'totalAlbumSize' => app('App\Http\Controllers\PublicImageController')->formatSizeUnits($totalAlbumSize),
            'lastUpdateAlbum' => $lastUpdateAlbum,
        );

        return view('welcome',compact('albums','images','stats'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchAlbum($id)

    {
        $album = Album::findOrFail($id);
        return $album;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
