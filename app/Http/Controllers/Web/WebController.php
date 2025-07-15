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

        $images = Image::where('album_id', $album->id)->orderBy('id', 'desc')->paginate(100);

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
    }
}
