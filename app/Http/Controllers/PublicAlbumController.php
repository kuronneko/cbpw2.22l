<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Image;
use App\Models\Comment;
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
        $comments = Comment::all()->sortByDesc("id");
        $albums = Album::where('visibility', 1)->orderBy('updated_at','desc')->paginate(6);
//fail test of bump albums    $albums = Album::where('visibility', 1)->whereHas('images', 'albums.id', '=', 'images.album_id')->orderBy('images.updated_at', 'desc')->paginate(5);
//SELECT DISTINCT ALBUMS.name from albums, images WHERE (albums.visibility=1) AND (albums.id=images.album_id) ORDER BY (images.updated_at) DESC
        $albumsFull = Album::where('visibility', 1)->orderBy('updated_at','desc')->get();

        $totalPublicVideos = 0;$totalPublicImages = 0;$totalAlbumSize = 0;$totalPublicComments = 0;$lastUpdateAlbum = 0;
        foreach ($albumsFull as $album) {
            foreach ($comments as $comment) {
                if($comment->album->id == $album->id){
                    $totalPublicComments++;
                }
           }
            foreach ($images as $image) {
                if($image->album->id == $album->id){
                   $totalAlbumSize = $totalAlbumSize + $image->size;
                   if($image->ext == "mp4" || $image->ext == "webm"){
                    $totalPublicVideos++;
                   }else{
                    $totalPublicImages++;
                   }
                }
            }
        }
        //$lastImageUploaded = app('App\Http\Controllers\PublicImageController')->searchImageById($max)->updated_at; //deprecated method using algoritm who obtain the max number id asuming that is the last image uploaded
        if(count($albumsFull) != 0){$lastUpdateAlbum = $albumsFull->first()->updated_at;}
        $stats = array(
            'totalPublicAlbums' => count($albumsFull),
            'totalPublicImages' => $totalPublicImages,
            'totalPublicVideos' => $totalPublicVideos,
            'totalPublicComments' => $totalPublicComments,
            'totalAlbumSize' => app('App\Http\Controllers\PublicImageController')->formatSizeUnits($totalAlbumSize),
            'lastUpdateAlbum' => $lastUpdateAlbum,
        );

        return view('welcome',compact('albums','images','stats','comments'));
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
