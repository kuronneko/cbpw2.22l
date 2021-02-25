<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Album;
use PhpParser\Node\Stmt\Foreach_;

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

        $request->validate([
            'name' => 'required',
            'text' => 'required'
        ]);

        $message = "";
        if($request->ajax()){
            $album = Album::find($request->albumId);
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

         return response()->json(['message' => $message]);
        }

    }

            /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reloadComments(Request $request)

    {
        $id = $request->albumId;
        $output = "";
        if($request->ajax()){
         $album = Album::find($id);
         $comments = Comment::where('album_id', $album->id)->orderBy('id','desc')->paginate(3);


         foreach($comments as $comment){
            $output .= "<div class='card text-white mb-2 bg-comments'>";
            $output .= "<div class='card-header d-flex justify-content-between align-items-center commentHeader'>";
            $output .= "<p class='text-danger'><strong>".htmlspecialchars($comment->name)."</strong>&nbsp;&nbsp;".$comment->created_at."&nbsp;&nbsp;No.".$comment->id."</p>";

            $output .= "</div>";
            $output .= "<div class='card-body commentBody'>";
            $output .= "<p>".htmlspecialchars($comment->text)."</p>";
                $output .= "</div>";
                $output .= "</div>";
         }

         return response()->json(['output' => $output]);
         //return response()->json(['response' => $response]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getTotalComments(Request $request)

    {
        $id = $request->albumId;
        if($request->ajax()){
         $album = Album::find($id);
         $comments = Comment::where('album_id', $album->id)->orderBy('id','desc')->get();

         return response()->json(['getTotalComments' => count($comments)]);
         //return response()->json(['response' => $response]);
        }

    }

            /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function commentAjaxLoad(Request $request)

    {

        $row = $request->row;
        $id = $request->albumId;
        $output = "";
        if($request->ajax()){
         $album = Album::find($id);
         $comments = Comment::where('album_id', $album->id)->orderBy('id','desc')->offset($row)->limit(3)->get();

         foreach($comments as $comment){
            $output .= "<div class='card text-white mb-2 bg-comments'>";
            $output .= "<div class='card-header d-flex justify-content-between align-items-center commentHeader'>";
            $output .= "<p class='text-danger'><strong>".htmlspecialchars($comment->name)."</strong>&nbsp;&nbsp;".$comment->created_at."&nbsp;&nbsp;No.".$comment->id."</p>";

            $output .= "</div>";
            $output .= "<div class='card-body commentBody'>";
            $output .= "<p>".htmlspecialchars($comment->text)."</p>";
                $output .= "</div>";
                $output .= "</div>";
         }
         return response()->json(['output' => $output]);
         //return response()->json(['response' => $response]);
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
        $comment = Comment::where('album_id', $album->id)->orderBy('id','desc')->offset(0)->limit(3)->get();
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
