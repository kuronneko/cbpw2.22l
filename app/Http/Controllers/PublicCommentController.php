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

        $request->validate([
            'name' => 'required',
            'text' => 'required'
        ]);

        $message = "";
        if($request->ajax()){
            $album = Album::findOrFail($request->albumId);
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
         $album = Album::findOrFail($id);
         $comments = Comment::where('album_id', $album->id)->orderBy('id','desc')->paginate(3);

         if(count($comments) == 0){
            $output .= "<div class='text-center mt-4 mb-4'>";
            $output .= "<i class='fas fa-exclamation-triangle'></i>";
            $output .= "<p class='text-secondary'>No comments found</p>";
            $output .= "</div>";
        }else{
            foreach($comments as $comment){
                $output .= "<div class='row bg-comments mb-1'>";
                $output .= "<div class='col-sm-12'>";
                $output .= "<div class='postNdate'>";
                $output .= "<p>".htmlspecialchars($comment->name)." ".$comment->created_at." No.<a style='color:#FF3333' href='javascript:quotePost('188')'>".$comment->id."</a></p>";
                $output .= "</div>";
                $output .= "</div>";
                $output .= "<div class='col-sm-12'>";
                $output .= "<div>";
                $output .= "<p>".htmlspecialchars($comment->text)."</p>";
                $output .= "</div>";
                $output .= "</div>";
                $output .= "</div>";
             }
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
         $album = Album::findOrFail($id);
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
         $album = Album::findOrFail($id);
         $comments = Comment::where('album_id', $album->id)->orderBy('id','desc')->offset($row)->limit(3)->get();
                if(count($comments) == 0){
                    $output .= "<div class='text-center mt-4 mb-4'>";
                    $output .= "<i class='fas fa-exclamation-triangle'></i>";
                    $output .= "<p class='text-secondary'>No comments found</p>";
                    $output .= "</div>";
                }else{
                    foreach($comments as $comment){
                        $output .= "<div class='row bg-comments mb-1'>";
                        $output .= "<div class='col-sm-12'>";
                        $output .= "<div class='postNdate'>";
                        $output .= "<p>".htmlspecialchars($comment->name)." ".$comment->created_at." No.<a style='color:#FF3333' href='javascript:quotePost('188')'>".$comment->id."</a></p>";
                        $output .= "</div>";
                        $output .= "</div>";
                        $output .= "<div class='col-sm-12'>";
                        $output .= "<div>";
                        $output .= "<p>".htmlspecialchars($comment->text)."</p>";
                        $output .= "</div>";
                        $output .= "</div>";
                        $output .= "</div>";
                     }
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
        abort(404);//
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
        abort(404);//
    }
}
