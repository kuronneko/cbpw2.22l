<?php

namespace App\Services;

use App\Models\Like;
use App\Models\Stat;
use App\Models\Album;
use App\Models\Image;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class UtilsService
{
    public static function eliminar_acentos($cadena)
    {
        //Reemplazamos la A y a
        $cadena = str_replace(
            array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
            array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
            $cadena
        );

        //Reemplazamos la E y e
        $cadena = str_replace(
            array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
            array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
            $cadena
        );

        //Reemplazamos la I y i
        $cadena = str_replace(
            array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
            array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
            $cadena
        );

        //Reemplazamos la O y o
        $cadena = str_replace(
            array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
            array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
            $cadena
        );

        //Reemplazamos la U y u
        $cadena = str_replace(
            array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
            array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
            $cadena
        );

        //Reemplazamos la N, n, C y c
        $cadena = str_replace(
            array('Ñ', 'ñ', 'Ç', 'ç'),
            array('N', 'n', 'C', 'c'),
            $cadena
        );

        return utf8_decode($cadena);
    }

    public static function formatSizeUnits($bytes)
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

    public static function getClientIp()
    {
        return getenv('HTTP_CLIENT_IP') ?: getenv('HTTP_X_FORWARDED_FOR') ?: getenv('HTTP_X_FORWARDED') ?: getenv('HTTP_FORWARDED_FOR') ?: getenv('HTTP_FORWARDED') ?: getenv('REMOTE_ADDR');
    }

    public static function generateRandomFakeIp()
    {
        return long2ip(rand(0, "4294967295"));
    }

        public function getCompleteStatistics2(){

        if(Auth::check() && auth()->user()->type == config('myconfig.privileges.super')){
            $albums = Album::orderBy('updated_at','desc')->get();
        }else{
            $albums = Album::where('visibility', 1)->orderBy('updated_at','desc')->get();
        }

        $albumPlucked = $albums->pluck('id');
        $stats =  Stat::whereIn('album_id', $albumPlucked->all())->get();

        $stats = array(
            'totalPublicAlbums' => count($stats),
            'totalPublicImages' => $stats->sum('qimage'),
            'totalPublicVideos' => $stats->sum('qvideo'),
            'totalPublicComments' => $stats->sum('qcomment'),
            'totalAlbumSize' => app('App\Services\UtilsService')->formatSizeUnits($stats->sum('size')),
            'lastUpdateAlbum' => $albums->first()->updated_at,
            'totalPublicViews' => $stats->sum('view'),
            'totalPublicLikes' => $stats->sum('qlike')
        );

        return $stats;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCompleteStatistics() //needs all images desc, with visibility filtered albums no paginate, and all comments desc
    {
        $imagesFull = Image::all()->sortByDesc("id");
        $commentsFull = Comment::all()->sortByDesc("id");
        $likesFull = Like::all()->sortByDesc("id");
        $albumsFull = Album::where('visibility', 1)->orderBy('updated_at','desc')->get();

        $totalPublicVideos = 0;$totalPublicImages = 0;$totalAlbumSize = 0;$totalPublicComments = 0;$lastUpdateAlbum = 0;$totalPublicViews = 0;$totalPublicLikes = 0;
        foreach ($albumsFull as $album) {
            $totalPublicViews = $totalPublicViews + $album->view;
            foreach ($commentsFull as $comment) {
                if($comment->album->id == $album->id){
                    $totalPublicComments++;
                }
           }
           foreach ($likesFull as $like) {
            if($like->album->id == $album->id){
                $totalPublicLikes++;
            }
       }
            foreach ($imagesFull as $image) {
                if($image->album->id == $album->id){
                   $totalAlbumSize = $totalAlbumSize + $image->size;
                   if($image->ext == "mp4" || $image->ext == "webm"){
                    $totalPublicVideos++;
                   }else{
                    $totalPublicImages++;
                   }
                }
            }
        }
        //$lastImageUploaded = app('App\Http\Controllers\PublicImageController')->searchImageById($max)->updated_at; //deprecated method using algoritm who obtain the max number id asuming that is the last image uploaded
        if(count($albumsFull) != 0){$lastUpdateAlbum = $albumsFull->first()->updated_at;}
        $stats = array(
            'totalPublicAlbums' => count($albumsFull),
            'totalPublicImages' => $totalPublicImages,
            'totalPublicVideos' => $totalPublicVideos,
            'totalPublicComments' => $totalPublicComments,
            'totalAlbumSize' => app('App\Services\UtilsService')->formatSizeUnits($totalAlbumSize),
            'lastUpdateAlbum' => $lastUpdateAlbum,
            'totalPublicViews' => $totalPublicViews,
            'totalPublicLikes' => $totalPublicLikes
        );

        return $stats;
    }

}
