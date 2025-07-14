<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Image;
use App\Models\Stat;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic;
use SebastianBergmann\Environment\Console;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use Lakshmaji\Thumbnail\Facade\Thumbnail;
use Carbon;
use Illuminate\Support\Facades\Auth;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ImageController extends Controller
{
    public function __construct()
    {
        if (config('myconfig.img.driver') == 'imagick') {
            ImageManagerStatic::configure(array('driver' => 'imagick'));
        }
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
            return view('super.image.create')->with('album', $album); //podria mandar el objeto album completo?????
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
        ImageService::validateRequest($request);

        $document = $request->file('file');
        $albumId = $request->input('albumId');
        $userId = $request->input('userId');
        $albumFound = Album::findOrFail($albumId);
        $websiteTag = config('myconfig.engine.nameext') . '_';
        $newFilename = md5($document->getClientOriginalName());
        $localUrl = Storage::url('public/images/' . 'profile_' . $userId . '/' . $albumFound->id . '/' . $websiteTag . $newFilename);
        $imgWaterMarkPath = config('myconfig.img.watermarkUrl');

        if (ImageService::checkUserPermissions($albumFound, $userId)) {
            if (!ImageService::fileExists($userId, $albumFound->id, $websiteTag, $newFilename, $document->getClientOriginalExtension(), $localUrl)) {

                if (ImageService::isVideo($document)) {
                    ImageService::processVideo($request, $userId, $albumFound, $websiteTag, $newFilename, $document);
                } else {
                    ImageService::insertImageData(
                        $albumFound,
                        $document,
                        ImageService::processImage($request, $userId, $albumFound, $websiteTag, $newFilename, $document, $imgWaterMarkPath),
                    );
                }

                ImageService::updateStatistics($albumFound, $document);
            } else {
                // duplicate file message
            }
        } else {
            return back()->with('message', 'Album ' . $albumFound->id . ' not found or cannot be accessed');
        }
    }
}
