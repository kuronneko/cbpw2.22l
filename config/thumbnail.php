<?php

/*
|--------------------------------------------------------------------------
| File which returns array of constants containing the thumbnail
| integration configurations.
|--------------------------------------------------------------------------
|
*/

return array(

    /*
    |--------------------------------------------------------------------------
    | FFMPEG BINARIES CONFIGURATIONS
    |--------------------------------------------------------------------------
    |
    | If you want to give binary paths explicitly, you can configure the FFMPEG
    | binary paths set to the below 'env' varibales.
    |
    | NOTE: FFMpeg will autodetect ffmpeg and ffprobe binaries.
    |        'ffmpeg'  => env('FFMPEG_PATH', '/usr/bin/ffmpeg'),
            'ffprobe' => env('FFPROBE_PATH', '/usr/bin/ffprobe'),
    */

    'binaries' => [
        'enabled' => env('FFMPEG_BINARIES', true),
        'path'    => [
            'ffmpeg'  => env('FFMPEG_PATH', '/usr/bin/ffmpeg'),
            'ffprobe' => env('FFPROBE_PATH', '/usr/bin/ffprobe'),
            'timeout' => env('FFMPEG_TIMEOUT', 3600), // The timeout for the underlying process
            'threads' => env('FFMPEG_THREADS', 12), // The number of threads that FFMpeg should use
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Thumbnail image dimensions
    |--------------------------------------------------------------------------
    |
    | Specify the dimensions for thumbnail image
    |
    */

    'dimensions' => [
        'width'  => env('THUMBNAIL_IMAGE_WIDTH', 720),
        'height' => env('THUMBNAIL_IMAGE_HEIGHT', 1280),
    ],

    /*
    |--------------------------------------------------------------------------
    | Thumbnail watermark alpha
    |--------------------------------------------------------------------------
    |
    | Specify the secret THUMBNAIL_X
    |
    */

    'watermark' => [
        'image' => [
            'enabled' => env('WATERMARK_IMAGE', false),
            'path'    => env('WATERMARK_PATH', '\xampp\htdocs\cbpw2.22l\public\storage\images\videoplay.png'),
        ],
        'video' => [
            'enabled' => env('WATERMARK_VIDEO', false),
            'path'    => env('WATERMARK_PATH', '\xampp\htdocs\cbpw2.22l\public\storage\images\videoplay.png'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Thumbnail some x
    |--------------------------------------------------------------------------
    |
    | Specify the secret THUMBNAIL_X
    |
    */

    'THUMBNAIL_X' => '<YOUR_THUMBNAIL_X>',

);

// php artisan vendor:publish

// end of file thumbnail.php
