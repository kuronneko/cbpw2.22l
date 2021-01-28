<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Image;

class PublicImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $album = app('App\Http\Controllers\PublicAlbumController')->searchAlbum($id);
        $images = Image::where('album_id', $id)->orderBy('id','desc')->paginate(100);

        $imagesFull = Image::where('album_id', $id)->orderBy('id','desc')->get();
        $imageCountperAlbum = 0;$albumSize = 0;
        foreach ($imagesFull as $image) {
           $imageCountperAlbum++;
           $albumSize = $albumSize + $image->size;
        }
        $stats = array();
        $stats['imageCountperAlbum'] = $imageCountperAlbum;
        $stats['updated_at'] = $album->updated_at;
        $stats['albumSize'] = $this->formatSizeUnits($albumSize);


        return view('content',compact('images','album','stats'));
        //return view('content',['images'=> $images, 'album'=> $album, 'imagesFull'=>$imagesFull, 'stats'=>$stats]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchImageById($id)

    {
        $image = Image::where('id',$id)->first();
        if($image){
            return $image;
        }

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
