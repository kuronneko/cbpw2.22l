<?php

namespace App\Http\Controllers\super;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Album;
use App\Models\Image;
use App\Models\Comment;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SuperTagController extends Controller
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
        if(Auth::check() && auth()->user()->type == config('myconfig.privileges.super')){
            return view('super.tag.index');
        }else{
            abort_if(auth()->user()->type != config('myconfig.privileges.super'), 204);
        }
        //$tags = Tag::all();
        //$imageArray = DB::select("SELECT images.id, images.album_id, images.url, images.ext, images.size, images.basename, images.ip, images.tag, images.created_at FROM images, albums, users WHERE (images.album_id=albums.id) AND (albums.user_id=users.id) AND (albums.user_id='$userId')");
        //$images = collect($imageArray); //this object is similar but no real image object, they have similar parameters than sql query and you cant get the relacionship objects like (album, user)
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
        /*
        $userId = auth()->user()->id;
        $album = Album::findOrFail($id);

    if(($album->user->id) == $userId){
        return view('super.tag.show');
    }else{
        return back()->with('message', 'Album '.$album->id.' not found or cannot be accessed');
    }
*/
abort(404);
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
