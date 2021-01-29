<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AlbumController extends Controller
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
        $albums = Album::where('user_id', $userId)->paginate(100);
        $images = Image::all();
        //$imageArray = DB::select("SELECT images.id, images.album_id, images.url, images.ext, images.size, images.basename, images.ip, images.tag, images.created_at FROM images, albums, users WHERE (images.album_id=albums.id) AND (albums.user_id=users.id) AND (albums.user_id='$userId')");
        //$images = collect($imageArray); //this object is similar but no real image object, they have similar parameters than sql query and you cant get the relacionship objects like (album, user)
        return view('admin.album.index',compact('albums','images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.album.create');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'visibility' => 'required'
        ]);

        $album = new Album();
        $album->user_id = auth()->user()->id;
        $album->name = $request->name;
        $album->description = $request->description;
        $album->visibility = $request->visibility;
        $album->save();

        return back()->with('message', 'Album create successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)

    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $userId = auth()->user()->id;
        $foundAlbum = Album::find($id);
        if(($foundAlbum->user->id) == $userId){
            return view("admin.album.edit", compact("foundAlbum"));
        }else{
            return back()->with('message', 'Album '.$foundAlbum->id.' not found or cannot be accessed');
        }
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
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'visibility' => 'required'
        ]);

        $userId = auth()->user()->id;
        $foundAlbum = Album::find($id);
        if(($foundAlbum->user->id) == $userId){
            $foundAlbum->name=$request->input("name");
            $foundAlbum->description=$request->input("description");
            $foundAlbum->visibility=$request->visibility;
            $foundAlbum->update();
            return back()->with('message', 'Album edited successfully');
        }else{
            return back()->with('message', 'Album '.$foundAlbum->id.' not found or cannot be accessed');
        }

    }

     /**
     * Fetch the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fetchAlbum(Request $request)

    {
       $id = $request->input("albumId");
       if($request->ajax()){
        $album = Album::find($id);
        return response()->json(['id' => $album->id, 'name' => $album->name]);
       }

    }


    /**
     * Destroy the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function destroy(Request $request)
    {

        $userId = auth()->user()->id;
        $albumId = $request->input("albumId");
        $foundAlbum = Album::find($albumId);

    if(($foundAlbum->user->id) == $userId){
        $images = Image::where('album_id', $foundAlbum->id);
        $images->delete();

        $folderPath = 'public/images/' . $foundAlbum->id;
        if (Storage::exists($folderPath)) {  //check if folder exist
            Storage::deleteDirectory($folderPath);
        }

        $album = Album::findOrFail($foundAlbum->id);
        $album->delete();

        return back()->with('message', 'Album deleted successfully');
    }else{
        return back()->with('message', 'Album '.$foundAlbum->id.' not found or cannot be accessed');
    }



    }
}
