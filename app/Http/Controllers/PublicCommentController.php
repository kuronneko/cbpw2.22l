<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Album;

class PublicCommentController extends Controller
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

        $message = "";
        if($request->ajax()){
            $album = Album::find($request->input('albumId'));
            $comment = new Comment();
            $comment->album_id = $album->id;
            $comment->name = $request->name;
            $comment->text = $request->text;
            $comment->ip = $request->ip();
            if($comment->save()){
                $message = "Comment sent successfully";
                $album->touch();
            }else{
                $message = "Critical Error";
            }

         return response()->json(['comment' => $comment, 'message' => $message]);
        }

    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showComment($id)

    {
        $album = Album::findOrFail($id);
        $comment = Comment::where('album_id', $album->id)->orderBy('id','desc')->paginate(3);
        $commentFull = Comment::where('album_id', $album->id)->orderBy('id','desc')->get();
        $commentType = array(
            'comment' => $comment,
            'commentFull' => $commentFull
        );
        return $commentType;
        //return view('content',compact('comment','album'));
        //return view('content',['images'=> $images, 'album'=> $album, 'imagesFull'=>$imagesFull, 'stats'=>$stats]);
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
