<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Comment;

use Illuminate\Http\Request;

class CommentController extends Controller
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
        abort(404);
        //
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
    public function showComment($id)

    {
        $userId = auth()->user()->id;
        $album = Album::findOrFail($id);

    if($album->user->id == $userId || auth()->user()->type == config('myconfig.privileges.super')){
        $comments = Comment::where('album_id', $album->id)->orderBy('id','desc')->paginate(100);
        return view('admin.comment.show',['comments'=> $comments, 'album'=> $album]);
    }else{
        return back()->with('message', 'Album '.$album->id.' not found or cannot be accessed');
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
    public function destroy(Request $request, $commentId)
    {
        $albumId = $request->input('albumId');
        $userId = auth()->user()->id;
        $albumFound = Album::findOrFail($albumId);
        $commentFound = Comment::findOrFail($commentId);

        if(($commentFound->album->id == $albumFound->id && $albumFound->user->id == $userId) || ($commentFound->album->id == $albumFound->id && auth()->user()->type == config('myconfig.privileges.super'))){

            $commentFound->delete();

            return redirect()->route('admin.comment.showComment', $albumFound->id);
        }else{
            return back()->with('message', 'Comment '.$commentFound->id.' not found or cannot be accessed');
        }
    }
}
