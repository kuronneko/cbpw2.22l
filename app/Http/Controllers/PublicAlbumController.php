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
        //fail test of bump albums    $albums = Album::where('visibility', 1)->whereHas('images', 'albums.id', '=', 'images.album_id')->orderBy('images.updated_at', 'desc')->paginate(5);
//SELECT DISTINCT ALBUMS.name from albums, images WHERE (albums.visibility=1) AND (albums.id=images.album_id) ORDER BY (images.updated_at) DESC
        $images = Image::all()->sortByDesc("id");
        $comments = Comment::all()->sortByDesc("id");
        $albums = Album::where('visibility', 1)->orderBy('updated_at','desc')->paginate(6);
        //abort_if($albums->isEmpty(), 204);
        $albumsFull = Album::where('visibility', 1)->orderBy('updated_at','desc')->get();
        $stats = $this->getCompleteStatistics($images, $albumsFull, $comments);
        return view('welcome',compact('albums','images','stats','comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCompleteStatistics($images, $albumsFull, $comments) //needs all images desc, with visibility filtered albums no paginate, and all comments desc
    {
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

        return $stats;
    }

    function getAjaxAlbums(Request $request)
    {

     if($request->ajax()){

      $output = "";
      $paginationType = 0;
      $query = $request->get('query');
      if($query != "") {
       $albums = Album::where('visibility', 1)->where('name', 'like', '%'.$query.'%')->orWhere('description', 'like', '%'.$query.'%')->orderBy('updated_at','desc')->get();
       //abort_if($albums->isEmpty(), 204);
       $images = Image::all()->sortByDesc("id");
       $comments = Comment::all()->sortByDesc("id");
       $paginationType = 0; //filtered
      }else{
         $albums = Album::where('visibility', 1)->orderBy('updated_at','desc')->paginate(6);
         //abort_if($albums->isEmpty(), 204);
       $images = Image::all()->sortByDesc("id");
       $comments = Comment::all()->sortByDesc("id");
       $paginationType = 1;//all
      }

      if(count($albums) > 0){
        //$output .= "<div class='row'>";
        foreach ($albums as $album) {
            # code...
        $videoCountperAlbum = 0;$imageLimitperAlbum = 0;$imageCountperAlbum = 0;$updated_at = $album->updated_at;$albumSize = 0;$commentCountperAlbum = 0;
        $output .= "<div class='col-12 col-sm-6'>";
        $output .= "<div class='card text-white indexCard mb-4'>";
        $output .= "<div class='card-header d-flex justify-content-between align-items-center'>";
        $output .= "<strong><p class='cardAlbumTittle text-danger'>Album: ".$album->name."</p></strong><p class='cardAlbumTittle text-secondary'>By: ".$album->user->name."</p>";
        $output .= "</div>";
        $output .= "<div class='card-body'>";
            if(session('message')){
                $output .= "<div class='alert alert-success'>{{ session('message') }}</div>";
            }
            $output .= "<p class='cardAlbumDescription'>Description: ".$album->description."</p>";
            $output .= "<div class='photos'>";
            foreach ($comments as $comment) {
                # code...
                if ($comment->album->id == $album->id){
                    $commentCountperAlbum++;
                }
            }
            foreach ($images as $image) {
                if($image->album->id == $album->id){
                    $albumSize = $albumSize + $image->size;
                    if ($image->ext == "mp4" || $image->ext == "webm"){
                        $videoCountperAlbum++;
                    }else{
                        $imageCountperAlbum++;
                    }
                    if($imageLimitperAlbum != 4){
                        $imageLimitperAlbum++;
                        if ($image->ext == "mp4" || $image->ext == "webm"){
                            $output .= "<img src='/cbpw2.22l/public/storage/images/videothumb.png' class='imgThumbPublicIndex masonry' data-was-processed='true'>";
                        }else{
                            $output .= "<img src='/cbpw2.22l/public/".$image->url."_thumb.".$image->ext."' class='imgThumbPublicIndex masonry' data-was-processed='true'>";
                        }
                    }
                }
            }

            $output .= "</div>";
    /// fin card body
        $output .= "</div>";
        $output .= "<div class='card-footer'>";
            $output .= "<span class='badge badge-dark'><i class='fas fa-images'></i><span class='badge badge-dark'>".$imageCountperAlbum." </span></span>&nbsp;";
            $output .= "<span class='badge badge-dark'><i class='fas fa-film'></i><span class='badge badge-dark'>".$videoCountperAlbum." </span></span>&nbsp;";
            $output .= "<span class='badge badge-dark'><i class='fas fa-comments'></i><span class='badge badge-dark'>".$commentCountperAlbum." </span></span>&nbsp;";
            $output .= "<span class='badge badge-dark'><i class='fas fa-redo-alt'></i><span class='badge badge-dark'>".$updated_at." </span></span>&nbsp;";
            $output .= "<span class='badge badge-dark'><i class='fas fa-hdd'></i><span class='badge badge-dark'>".app('App\Http\Controllers\PublicImageController')->formatSizeUnits($albumSize)."</span></span>";
            $output .= "<a href='album/".$album->id."/content' class='stretched-link'></a>";
            $output .= "</div>";
        $output .= "</div>";
        $output .= "</div>";
    }
    //$output .= "</div>";

      }else{
        $output .= "<div class='col-sm-12'>";
        $output .= "<div class='text-center'>";
        $output .= "<img src='/cbpw2.22l/public/storage/images/404.png' class='img-responsive girl404' data-was-processed='true'>";
        $output .= "</div>";
        $output .= "</div>";
      }

      return response()->json(['output' => $output, 'paginationType' => $paginationType]);
     }

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
