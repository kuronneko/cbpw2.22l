<?php

namespace App\Http\Controllers\Web;

use App\Models\Stat;
use App\Models\User;

use App\Models\Album;
use App\Models\Image;
use App\Models\Location;
use App\Models\Material;
use App\Models\EmbedVideo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;

class WebController extends Controller
{
    /**
     * Redirect to the appropriate profile based on user type.
     *
     * @return \Illuminate\View\View
     */
    public function redirect()
    {
        return view('super.profile.index');
        /*         if (auth()->user()->type == config('myconfig.privileges.super')) {
            $album = Album::where('user_id', auth()->user()->id)->first();
            return view('super.profile.index', ['album' => $album]);
        } else {
            $album = Album::where('user_id', auth()->user()->id)->first();
            return view('escort.profile.index', ['album' => $album]);
        } */
    }

    public function showContent($id)
    {

        $album = Album::findOrFail($id);
        if (!Auth::check() && $album->visibility == 0) {
            abort(404);
        } elseif (Auth::check() && Auth::user()->id != $album->user_id && $album->visibility == 0 && Auth::user()->type != config('myconfig.privileges.super')) {
            abort(404);
        }

        if ($album->type == config('myconfig.albumType.embedvideo')) {
            $embedvideo = EmbedVideo::where('album_id', $album->id)->first();
        }
        $stat = Stat::where('album_id', $album->id)->first();
        if ($stat) {
            $stat->view = $stat->view + 1;
            $stat->save();
        }
        //$album->view = $album->view + 1;
        //$album->timestamps = false;
        //$album->update();
        $images = Image::where('album_id', $album->id)->orderBy('id', 'desc')->paginate(100);
        //abort_if($images->isEmpty(), 204); // if images object is empty redirect to 204 error
        //$imagesFull = Image::where('album_id', $album->id)->orderBy('id','desc')->get();
        //$commentFull = Comment::where('album_id', $album->id)->orderBy('id','desc')->get();
        //$commentsType = app('App\Http\Controllers\PublicCommentController')->getCommentType($album->id); //return array with ['comment'] paginate and ['commentFull'] full coments;
        //$tags = Tag::all()->sortByDesc('id');
        //$stats = $this->getAlbumStats($imagesFull, $album, $commentFull);

        if (Auth::check()) {
            $userId = auth()->user()->id;
        } else {
            $userId = "";
        }

        if ($album->type == config('myconfig.albumType.embedvideo')) {
            return view('content-e', compact('images', 'album', 'stat', 'userId', 'embedvideo'));
        } else {
            return view('content', compact('images', 'album', 'stat', 'userId'));
        }
        //return view('content',['images'=> $images, 'album'=> $album, 'imagesFull'=>$imagesFull, 'stats'=>$stats]);

    }

}
