<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Image;
use App\Models\Comment;

class ProfileController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->id;

        if(auth()->user()->type == config('myconfig.privileges.super')){
            $albums = Album::orderBy('updated_at', 'desc')->paginate(100);
            $images = Image::all();
            //$imageArray = DB::select("SELECT images.id, images.album_id, images.url, images.ext, images.size, images.basename, images.ip, images.tag, images.created_at FROM images, albums, users WHERE (images.album_id=albums.id) AND (albums.user_id=users.id) AND (albums.user_id='$userId')");
            //$images = collect($imageArray); //this object is similar but no real image object, they have similar parameters than sql query and you cant get the relacionship objects like (album, user)
            return view('admin.profile.index',compact('albums','images'));
        }else{
            $albums = Album::where('user_id', $userId)->orderBy('updated_at','desc')->paginate(100);
            $images = Image::all();
            //$imageArray = DB::select("SELECT images.id, images.album_id, images.url, images.ext, images.size, images.basename, images.ip, images.tag, images.created_at FROM images, albums, users WHERE (images.album_id=albums.id) AND (albums.user_id=users.id) AND (albums.user_id='$userId')");
            //$images = collect($imageArray); //this object is similar but no real image object, they have similar parameters than sql query and you cant get the relacionship objects like (album, user)
            return view('admin.profile.index',compact('albums','images'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
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
        abort(404);
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
        abort(404);
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
        abort(404);
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
        abort(404);
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
        abort(404);
        //
    }
}
