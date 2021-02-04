<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic;
use SebastianBergmann\Environment\Console;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
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

        if ($request->get('name')) {
            \Image::delete(public_path('images/' . $request->get('name')));
        }

    }
*/
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createImage($id)
    {
        $userId = auth()->user()->id;
        $album = Album::find($id);

        if (($album->user->id) == $userId) {
            return view('admin.image.create')->with('album', $album); //podria mandar el objeto album completo?????
        } else {
            return back()->with('message', 'Album ' . $album->id . ' not found or cannot be accessed');
        }
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
        $album = Album::find($id);

        if (($album->user->id) == $userId) {
            $images = Image::where('album_id', $album->id)->orderBy('id', 'desc')->paginate(100);
            return view('admin.image.show', ['images' => $images, 'album' => $album]);
        } else {
            return back()->with('message', 'Album ' . $album->id . ' not found or cannot be accessed');
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
            'file' => 'required|mimes:mp4,webm,gif,png,jpg,jpeg|max:100000'
        ]);

        $document = $request->file('file');
        $albumId = $request->input('albumId');
        $userId = auth()->user()->id;
        $albumFound = Album::find($albumId);

        if (($albumFound->user->id == $userId)) {
            $newFilename = md5($document->getClientOriginalName());  //rename filename

            $albumFolderPath = public_path('/storage/images/' . $albumFound->id);
            if (!file_exists($albumFolderPath)) {       //check if folder exist

                mkdir($albumFolderPath, 0755, true);
            }

            $filePath = public_path('/storage/images/' . $albumFound->id . '/' . $newFilename . '.' . $document->getClientOriginalExtension());
            if (!file_exists($filePath)) {             //check if physical file exist

                $request->file('file')->storeAs('public/images/' . $albumFound->id, $newFilename . '.' . $document->getClientOriginalExtension()); //upload main file
                $url = Storage::url('public/images/' . $albumFound->id . '/' . $newFilename); //url without extension

                if ($document->getClientOriginalExtension() == "mp4" || $document->getClientOriginalExtension() == "webm") {

                } else {
                    $thumbTarget = public_path('/storage/images/' . $albumFound->id . '/' . $newFilename . '_thumb.' . $document->getClientOriginalExtension()); //generate thumbnail with intervention image library
                    ImageManagerStatic::make($request->file('file')->getRealPath())->resize(200, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->resizeCanvas(200, null)->save($thumbTarget, 80);
                }
            }


            if (Image::find($url)) { //check if image exist in DB based by URL parameters old method [[$image = Image::where('url',$url)->first();if($image){return $image;}]]

            } else {
                $image = new Image();
                $image->album_id = $albumFound->id;
                $image->url = $url;
                $image->ext = $document->getClientOriginalExtension();
                $image->size = $document->getSize();
                $image->basename = $document->getClientOriginalName();
                $image->ip = $request->ip();
                $image->tag = "";
                $image->save();
                $albumFound->touch();
            }

            //dump($url); //"/storage/images/nULq23739EEZlKhwjUwDmad7fzasjZ7P5uxk3uaz.jpg"
            //dump($imageFiles); //"public/images/nULq23739EEZlKhwjUwDmad7fzasjZ7P5uxk3uaz.jpg"
        } else {
            return back()->with('message', 'Album ' . $albumFound->id . ' not found or cannot be accessed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $url
     * @return $bytes
     */
    public function formatSizeUnits($bytes)

    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' Bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' Byte';
        } else {
            $bytes = '0 Bytes';
        }

        return $bytes;
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
        $userId = auth()->user()->id;
        $albumFound = Album::find($albumId);
        $imageFound = Image::find($imageId);

        if (($imageFound->album->id == $albumFound->id && $albumFound->user->id == $userId)) {

            $productImage = str_replace('/storage', '', $imageFound->url);

            Storage::delete('/public' . $productImage . '.' . $imageFound->ext);
            Storage::delete('/public' . $productImage . '_thumb.' . $imageFound->ext);

            $imageFound->delete();

            return redirect()->route('admin.image.showImage', $albumFound->id);
        } else {
            return back()->with('message', 'Image ' . $imageFound->id . ' not found or cannot be accessed');
        }
    }
}
