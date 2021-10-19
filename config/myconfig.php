<?php


return [
    'patch-pre-ffmpeg' =>
        [       // turn off ffmpeg set 9999999 and false
                // enable is 0 and true
            'image-id-less' => 0, //this works to fix the no existence of video thumbnail before ffmpeg implementation (0 set all video thumbnails on) and number less than "30" for example, put all 30 elements before with the default video thumbnail (not generate)
            'ffmpeg-status' => true,

            'videoPlayWatermarkUrl' => public_path('/img/videoplay4.png'),
            'ffmpeg-watermark' => false, //insert watermark using laravel ffmpeg and render video again, false dont inser watermark in
            'videoWaterMarkName' => 'watermark_video.png', //watermark video must be located on public/img/watermark_video.png
        ],
    'img' =>
        [   'avatar' => '/img/avatar.png',
            'backgroundLogo' => '/img/backgroundLogo.jpg',
            'url' => '/cbpw2.22l/public/',  // /cbpw2.22l/public/ is the htdocs proyect folder // in production you can delete it and just write /public/
            'driver' => 'gd', //imagick or default gd

            'resize' => false,  //resize image
            'resizeWidth' => 720,
            'resizeHeight' => 720,
            'watermark' => false, //inser watermark on image
            'watermarkUrl' => public_path('/img/watermark.png'),
            'thumbnailsAlbumSize' => 200,
            'thumbnailsAlbumQuality' => 80,

            'avatarResize' => false,  //resize image
            'avatarResizeWidth' => 720,
            'avatarResizeHeight' => 720,
            'avatarWatermark' => false, //inser watermark on image
            'avatarWatermarkUrl' => public_path('/img/watermark.png'),
            'thumbnailsAvatarSize' => 300,
            'thumbnailsAvatarQuality' => 80,
        ],
    'engine' =>
        [
            'nameext' => 'cyberpunkwaifus.xyz',
            'name' => 'Cyberpunkwaifus',
            'version' => '2.22160',
            'date' => '8/20/2021',
        ],
    'privileges' =>
        [
            'admin' => 1, // restricted user  (banned user)
            'admin++' => 2, // premium user++   (profile edit, but no visibility status)
            'admin+++' => 3, // premium user+++ (full and can change visibility status)
            'user' => 4,
            'super' => 5, // super admin can manager normal users (admin)
        ],
];


?>
