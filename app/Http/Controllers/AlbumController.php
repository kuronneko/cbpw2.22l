<?php

namespace App\Http\Controllers;

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
        return view('album.index',compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('album.create');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createImage($id){
        $userId = auth()->user()->id;
        $album = $this->searchAlbum($id);
        if(($album->user->id) == $userId){
            return view('image.create')->with('album',$album); //podria mandar el objeto album completo?????
        }else{
            return back()->with('message', 'Album '.$id.' not found or cannot be accessed');
        }

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
            'description' => 'required'
        ]);

        $album = new Album();
        $album->user_id = auth()->user()->id;
        $album->name = $request->name;
        $album->description = $request->description;
        $album->save();

        return back()->with('message', 'Album create successfully');
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showImage($id)

    {
        $userId = auth()->user()->id;
        $album = $this->searchAlbum($id);

    if(($album->user->id) == $userId){
        $images = Image::where('album_id', $id)->paginate(100);
        return view('album.show',['images'=> $images, 'album'=> $album]);
    }else{
        return back()->with('message', 'Album '.$id.' not found or cannot be accessed');
    }

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
        $foundAlbum = $this->searchAlbum($id);
        if(($foundAlbum->user->id) == $userId){
            $album = Album::findOrFail($id);
            return view("album.edit", compact("album"));
        }else{
            return back()->with('message', 'Album '.$id.' not found or cannot be accessed');
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
            'description' => 'required'
        ]);

        $userId = auth()->user()->id;
        $foundAlbum = $this->searchAlbum($id);
        if(($foundAlbum->user->id) == $userId){
            $album = Album::findOrFail($id);
            $album->name=$request->input("name");
            $album->description=$request->input("description");
            $album->update();
            return back()->with('message', 'Album edited successfully');
        }else{
            return back()->with('message', 'Album '.$id.' not found or cannot be accessed');
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
        $album = $this->searchAlbum($id);
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
        $foundAlbum = $this->searchAlbum($albumId);

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
        return back()->with('message', 'Album '.$albumId.' not found or cannot be accessed');
    }



    }
}
