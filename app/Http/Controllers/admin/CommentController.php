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


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showComment($id)

    {
        $userId = auth()->user()->id;
        $album = Album::find($id);

    if($album->user->id == $userId || auth()->user()->type == 1){
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
    public function destroy(Request $request, $commentId)
    {
        $albumId = $request->input('albumId');
        $userId = auth()->user()->id;
        $albumFound = Album::find($albumId);
        $commentFound = Comment::find($commentId);

        if(($commentFound->album->id == $albumFound->id && $albumFound->user->id == $userId) || ($commentFound->album->id == $albumFound->id && auth()->user()->type == 1)){

            $commentFound->delete();

            return redirect()->route('admin.comment.showComment', $albumFound->id);
        }else{
            return back()->with('message', 'Comment '.$commentFound->id.' not found or cannot be accessed');
        }
    }
}
