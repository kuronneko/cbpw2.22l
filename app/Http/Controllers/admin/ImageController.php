<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Image;
use App\Models\Stat;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic;
use SebastianBergmann\Environment\Console;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use Lakshmaji\Thumbnail\Facade\Thumbnail;
use Carbon;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;


class ImageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        if(config('myconfig.img.driver') == 'imagick'){
        ImageManagerStatic::configure(array('driver' => 'imagick'));
        }
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
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createImage($id)
    {
        $userId = auth()->user()->id;
        $album = Album::findOrFail($id);

        if (($album->user->id == $userId && (auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++'))) || auth()->user()->type == config('myconfig.privileges.super')) {
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
        $album = Album::findOrFail($id);

        if (($album->user->id == $userId && (auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++'))) || auth()->user()->type == config('myconfig.privileges.super')) {
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
            'file' => 'required|mimes:mp4,webm,gif,png,jpg,jpeg|max:1024000' //1000 mb max filesize
        ]);

        $document = $request->file('file');
        $albumId = $request->input('albumId');
        $userId = $request->input('userId');
        $albumFound = Album::findOrFail($albumId);
        $websiteTag = config('myconfig.engine.nameext').'_';
        $newFilename = md5($document->getClientOriginalName());  //rename filename
        $url = Storage::url('public/images/' . 'profile_'.$userId.'/'. $albumFound->id . '/' . $websiteTag . $newFilename); //url without extension
        $imgWaterMarkPath = config('myconfig.img.watermarkUrl');//public_path('/img/watermark.png'); //remeber check this url

        if (($albumFound->user->id == $userId && (auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++'))) || auth()->user()->type == config('myconfig.privileges.super')) {

            if (!file_exists(public_path('/storage/images/' . 'profile_'.$userId.'/'.$albumFound->id))) {       //check if folder exist
                mkdir(public_path('/storage/images/' . 'profile_'.$userId.'/'.$albumFound->id), 0755, true);
            }

            if (!file_exists(public_path('/storage/images/' . 'profile_'.$userId.'/'. $albumFound->id . '/' . $websiteTag . $newFilename . '.' . $document->getClientOriginalExtension())) && !Image::where('url', $url)->where('album_id', $albumFound->id)->first()) {             //check if physical file exist
                // 'public/images/' required in test, and 'images/' for production

                //database insert
                $image = new Image();
                $image->album_id = $albumFound->id;
                $image->url = $url;
                $image->ext = $document->getClientOriginalExtension();
                $image->size = $document->getSize();
                $image->basename = $document->getClientOriginalName();
                $image->ip = $request->ip();
                $image->tag = "";
                $image->save();

                $stat = Stat::where('album_id', $albumFound->id)->first();
                if($stat){
                    $stat->size = $stat->size + $document->getSize();
                    if ($document->getClientOriginalExtension() == "mp4" || $document->getClientOriginalExtension() == "webm"){
                        $stat->qvideo = $stat->qvideo + 1;
                    }else{
                        $stat->qimage = $stat->qimage + 1;
                    }
                    $stat->save();
                    $albumFound->touch();
                }else{
                    $stat = new Stat();
                    $stat->album_id = $albumFound->id;
                    $stat->size = $document->getSize();
                    if ($document->getClientOriginalExtension() == "mp4" || $document->getClientOriginalExtension() == "webm"){
                        $stat->qvideo = 1;
                        $stat->qimage = 0;
                    }else{
                        $stat->qimage = 1;
                        $stat->qvideo = 0;
                    }
                    $stat->qcomment = 0;
                    $stat->qlike = 0;
                    $stat->view = 0;
                    $stat->save();
                    $albumFound->touch();
                }


                if(($document->getClientOriginalExtension() == "mp4" || $document->getClientOriginalExtension() == "webm")){
                //main file upload
                    if(config('myconfig.patch-pre-ffmpeg.ffmpeg-watermark') == true){
                //upload main file
                        $request->file('file')->storeAs('public/images/' . 'profile_'.$userId.'/'. $albumFound->id, $websiteTag . $newFilename . '_temp.' . $document->getClientOriginalExtension());
                        if($document->getClientOriginalExtension() == "mp4"){ //check video format to encode
                            $format = new \FFMpeg\Format\Video\X264;
                        }else{
                            $format = new \FFMpeg\Format\Video\WebM;
                        }
                        FFMpeg::fromDisk('public') //uses ffmpeg laravel to insert watermark on video
                        ->open('/images/' . 'profile_'.$userId.'/'.  $albumFound->id . '/' . $websiteTag . $newFilename . '_temp.' . $document->getClientOriginalExtension())
                        ->addWatermark(function(WatermarkFactory $watermark) {
                            $watermark->fromDisk('assets')
                            ->open(config('myconfig.patch-pre-ffmpeg.videoWaterMarkName'))
                            ->horizontalAlignment(WatermarkFactory::CENTER)
                            ->verticalAlignment(WatermarkFactory::CENTER);
                        })
                        ->export()
                        ->toDisk('public')
                        ->inFormat($format)
                        ->save('/images/' . 'profile_'.$userId.'/'.  $albumFound->id . '/' . $websiteTag . $newFilename . '.' . $document->getClientOriginalExtension());
                        //delete temp main video file
                        Storage::disk('public')->delete('/images/' . 'profile_'.$userId.'/'. $albumFound->id . '/' . $websiteTag . $newFilename . '_temp.' . $document->getClientOriginalExtension());
                    }else{
                        $request->file('file')->storeAs('public/images/' . 'profile_'.$userId.'/'. $albumFound->id, $websiteTag . $newFilename . '.' . $document->getClientOriginalExtension());
                    }

                    if(config('myconfig.patch-pre-ffmpeg.ffmpeg-status') == true){
                      //generate video thumbnail with Lakshmaji video thumbnail library
                        $videoPath = public_path('/storage/images/' .'profile_'.$userId.'/'.  $albumFound->id . '/' . $websiteTag . $newFilename . '.' . $document->getClientOriginalExtension());
                        $thumbnailPath = public_path('/storage/images/' . 'profile_'.$userId.'/'. $albumFound->id . '/');
                        $thumbnailImageName  = $websiteTag . $newFilename . '_thumb.jpg';
                        $timeToImage = 2;
                        Thumbnail::getThumbnail($videoPath,$thumbnailPath,$thumbnailImageName,$timeToImage); //generate default size thumbnail from video with Lakshmaji library (watermark settings OFF)

                        $thumbnailPathResize = public_path('/storage/images/' . 'profile_'.$userId.'/'. $albumFound->id . '/' . $websiteTag . $newFilename . '_thumb.jpg');
                        $videoWaterMarkPath = config('myconfig.patch-pre-ffmpeg.videoPlayWatermarkUrl'); //remeber check this url
                        if(config('myconfig.img.thumbnailsAlbumsFit') == true){
                            ImageManagerStatic::make($thumbnailPathResize)->fit(config('myconfig.img.thumbnailsAlbumSizeWidth'),config('myconfig.img.thumbnailsAlbumSizeHeight'))->insert($videoWaterMarkPath, 'center')->save($thumbnailPathResize, config('myconfig.img.thumbnailsAlbumQuality')); //->insert($waterMarkPath, 'bottom-left', 5, 5);
                        }else{
                            ImageManagerStatic::make($thumbnailPathResize)->resize(config('myconfig.img.thumbnailsAlbumSize'), null, function ($constraint) { //resize Lakshmaji thumbnail with intervention image library and INSERT watermark with the same library
                                $constraint->aspectRatio();
                                })->resizeCanvas(config('myconfig.img.thumbnailsAlbumSize'), null)->insert($videoWaterMarkPath, 'center')->save($thumbnailPathResize, config('myconfig.img.thumbnailsAlbumQuality')); //->insert($waterMarkPath, 'bottom-left', 5, 5);
                        }

                    }

                }else{


                    if(config('myconfig.img.resize') == true){
                        if(ImageManagerStatic::make($request->file('file')->getRealPath())->width() > ImageManagerStatic::make($request->file('file')->getRealPath())->height()){ //check dimension of image
                            $imgResized = ImageManagerStatic::make($request->file('file')->getRealPath())->resize(config('myconfig.img.resizeWidth'), null, function ($constraint) { //resize image based on width
                                $constraint->aspectRatio();
                            })->resizeCanvas(config('myconfig.img.resizeWidth'), null);
                        }else{
                            $imgResized = ImageManagerStatic::make($request->file('file')->getRealPath())->resize(null, config('myconfig.img.resizeHeight'), function ($constraint) { //Resize image based on height
                                $constraint->aspectRatio();
                            })->resizeCanvas(null, config('myconfig.img.resizeHeight'));
                        }
                    }else{
                        //upload image with no resize it
                        $imgResized = ImageManagerStatic::make($request->file('file')->getRealPath());
                    }

                     if(config('myconfig.img.watermark') == true){
                        $imgResized->insert(ImageManagerStatic::make($imgWaterMarkPath)->resize(round($imgResized->width()/2), null, function ($constraint) { //insert and resize watermark based on imageresize width
                            $constraint->aspectRatio();
                        })->resizeCanvas(round($imgResized->width()/2), null)->opacity(50), 'center')->save(public_path('/storage/images/' . 'profile_'.$userId.'/'. $albumFound->id . '/' . $websiteTag . $newFilename . '.' . $document->getClientOriginalExtension()), 100); //inser resize watermark on resize image
                     }else{
                        $imgResized->save(public_path('/storage/images/' . 'profile_'.$userId.'/'. $albumFound->id . '/' . $websiteTag . $newFilename . '.' . $document->getClientOriginalExtension()), 100);
                     }
                            //imageThumbnails
                            //big image files require imagick drive to resize it, because GD drivers need a lot of ram to do it.
                            if(config('myconfig.img.thumbnailsAlbumsFit') == true){
                                ImageManagerStatic::make($imgResized)->fit(config('myconfig.img.thumbnailsAlbumSizeWidth'), config('myconfig.img.thumbnailsAlbumSizeHeight'))->save(public_path('/storage/images/' . 'profile_'.$userId.'/'. $albumFound->id . '/' . $websiteTag . $newFilename . '_thumb.' . $document->getClientOriginalExtension()), config('myconfig.img.thumbnailsAlbumQuality'));
                            }else{
                                ImageManagerStatic::make($imgResized)->resize(config('myconfig.img.thumbnailsAlbumSize'), null, function ($constraint) {  //generate thumbnail from imgResized with watermark included, you can change it by $request->file('file')->getRealPath() without watermark
                                    $constraint->aspectRatio();
                                })->resizeCanvas(config('myconfig.img.thumbnailsAlbumSize'), null)->save(public_path('/storage/images/' . 'profile_'.$userId.'/'. $albumFound->id . '/' . $websiteTag . $newFilename . '_thumb.' . $document->getClientOriginalExtension()), config('myconfig.img.thumbnailsAlbumQuality'));
                            }
                }

            }else{
                //duplicate file message
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $imageId)
    {


        $albumId = $request->input('albumId');
        $userId = auth()->user()->id;
        $albumFound = Album::findOrFail($albumId);
        $imageFound = Image::findOrFail($imageId);
        $statFound = Stat::where('album_id', $albumFound->id)->first();

        if (($imageFound->album->id == $albumFound->id && $albumFound->user->id == $userId && (auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++'))) || ($imageFound->album->id == $albumFound->id && auth()->user()->type == config('myconfig.privileges.super'))) {

            $productImage = str_replace('/storage', '', $imageFound->url);

            if ($imageFound->ext == "mp4" || $imageFound->ext == "webm"){
                if($statFound->qvideo == 0){

                }else{
                    $statFound->qvideo = $statFound->qvideo - 1;
                }
            }else{
                if($statFound->qimage == 0){

                }else{
                    $statFound->qimage = $statFound->qimage - 1;
                }
            }
            $statFound->size = $statFound->size - $imageFound->size;
            $statFound->save();

            Storage::delete('/public' . $productImage . '.' . $imageFound->ext);

            if($imageFound->ext == "mp4" || $imageFound->ext == "webm"){ //fix video thumbnail delete
                Storage::delete('/public' . $productImage . '_thumb.jpg');
            }else{
                Storage::delete('/public' . $productImage . '_thumb.' . $imageFound->ext);
            }


            $imageFound->delete();

            return redirect()->route('admin.image.showImage', $albumFound->id);
        } else {
            return back()->with('message', 'Image ' . $imageFound->id . ' not found or cannot be accessed');
        }
    }
}
