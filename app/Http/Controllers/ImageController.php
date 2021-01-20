<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic;
use SebastianBergmann\Environment\Console;

class ImageController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    function upload(Request $request){
     $image = $request->file('file');
     $imageName = time() . '.' . $image->extension();
     $image->move(public_path('images'), $imageName);
     return response()->json(['success' => $imageName]);
    }

    function fetch(){
     $images = \Image::allFiles(public_path('images'));
     $output = '<div class="row">';
     foreach($images as $image){
      $output .= '
      <div class="col-md-2" style="margin-bottom:16px;" align="center">
                <img src="'.asset('images/' . $image->getFilename()).'" class="img-thumbnail" width="175" height="175" style="height:175px;" />
                <button type="button" class="btn btn-link remove_image" id="'.$image->getFilename().'">Remove</button>
            </div>
      ';
     }
     $output .= '</div>';
     echo $output;
    }

    function delete(Request $request){
     if($request->get('name')){
        \Image::delete(public_path('images/' . $request->get('name')));
     }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'file' => 'required|image|max:100000'
        ]);

        $document = $request->file('file');
        $albumId = $request->input('albumId');
        $newFilename = md5( $document->getClientOriginalName() ).".".$document->getClientOriginalExtension();  //rename filename

        $albumFolderPath = public_path('/storage/images/'.$albumId);
        if (!file_exists($albumFolderPath)) {       //check if folder exist

            mkdir($albumFolderPath, 0755, true);
        }

        $filePath = public_path('/storage/images/'.$albumId.'/'.$newFilename);
        if (!file_exists($filePath)) {             //check if physical file exist

            $imageFiles = $request->file('file')->storeAs('public/images/'. $albumId, $newFilename);
            $url = Storage::url($imageFiles);

            $thumbTarget = public_path('/storage/images/' . $albumId . '/'. $newFilename . 'thumb.'.$document->getClientOriginalExtension()); //generate thumbnail with intervention image library
            ImageManagerStatic::make($request->file('file')->getRealPath())->resize(200,null, function($constraint)
            {
                $constraint->aspectRatio();
            })->resizeCanvas(200,null)->save($thumbTarget, 80);
        }


           if($this->searchImageByUrl($url)){ //check if image exist in DB based by URL parameters

           }else{
            $image = new Image();
            $image->album_id = $albumId;
            $image->url = $url;
            $image->ext = $document->getClientOriginalExtension();
            $image->size = $document->getSize();
            $image->basename = $document->getClientOriginalName();
            $image->ip = $request->ip();
            $image->tag = "";
            $image->save();
           }

//dump($url); //"/storage/images/nULq23739EEZlKhwjUwDmad7fzasjZ7P5uxk3uaz.jpg"
//dump($imageFiles); //"public/images/nULq23739EEZlKhwjUwDmad7fzasjZ7P5uxk3uaz.jpg"

    }

     /**
     * Display the specified resource.
     *
     * @param  string  $url
     * @return \Illuminate\Http\Response
     */
    public function searchImageByUrl($url)

    {
        $image = Image::where('url',$url)->first();
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $imageId)
    {

        $albumId = $request->input('albumId');

        $foundImage = $this->searchImageById($imageId);
        $productImage = str_replace('/storage', '', $foundImage->url);
        Storage::delete('/public' . $productImage);
        Storage::delete('/public' . $productImage.'thumb.'.$foundImage->ext);

        $image = Image::findOrFail($imageId);
        $image->delete();

        return redirect()->route('album.showImage', $albumId);

    }
}
