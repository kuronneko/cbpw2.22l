<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Album;
use App\Models\Image;
use App\Models\Tag;

class PublicImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort(404); //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404); //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(404); //
    }

    public function formatSizeUnits($bytes)

    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' Bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' Byte';
        }
        else
        {
            $bytes = '0 Bytes';
        }

        return $bytes;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showContent($id)

    {

        $album = Album::findOrFail($id);

        $album->view = $album->view + 1;
        $album->timestamps = false;
        $album->update();

        $images = Image::where('album_id', $album->id)->orderBy('id','desc')->paginate(100);
        abort_if($images->isEmpty(), 204); // if images object is empty redirect to 204 error

        $imagesFull = Image::where('album_id', $album->id)->orderBy('id','desc')->get();
        $commentsType = app('App\Http\Controllers\PublicCommentController')->showComment($album->id); //return array with ['comment'] paginate and ['commentFull'] full coments;
        $tags = Tag::all()->sortByDesc('id');
        $stats = $this->getAlbumStats($imagesFull, $album, $commentsType);
        $comments = $commentsType['comment'];

        if (Auth::check()){
            $userId = auth()->user()->id;
        }else{
            $userId = "";
        }

        return view('content',compact('images','album','stats','comments','tags','userId'));
        //return view('content',['images'=> $images, 'album'=> $album, 'imagesFull'=>$imagesFull, 'stats'=>$stats]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAlbumStats($imagesFull, $album, $commentsType)
    {
        $totalPublicVideos = 0;$totalPublicImages = 0;$albumSize = 0;//$imageCountperAlbum = 0;
        foreach ($imagesFull as $image) {
           //$imageCountperAlbum++;
           $albumSize = $albumSize + $image->size;
           if($image->ext == "mp4" || $image->ext == "webm"){
            $totalPublicVideos++;
           }else{
            $totalPublicImages++;
           }
        }

        $stats = array();
        $stats['imageCountperAlbum'] = $totalPublicImages;
        $stats['videoCountperAlbum'] = $totalPublicVideos;
        $stats['updated_at'] = $album->updated_at;
        $stats['albumSize'] = $this->formatSizeUnits($albumSize);
        $stats['commentCountperAlbum'] = count($commentsType['commentFull']);
        //$stats['randomAlbum'] = 0; try to get random image album
        $stats['viewCountperAlbum'] = $album->view;

        return $stats;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404); //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404); //
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
        abort(404); //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(404); //
    }
}
