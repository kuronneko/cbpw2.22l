<?php


return [
    'patch-pre-ffmpeg' =>
        [
             //this works to fix the no existence of video thumbnail before ffmpeg implementation (0 set all video thumbnails on) and number less than "30" for example, put all 30 elements before with the default video thumbnail (not generate)
             //this is deprecated since 7/16/2025
             //'image-id-less' => 9999999,

            // this enable the generation of video thumbnails using ffmpeg, if false, the video thumbnail is not generated
            // and it inserts a image object with the thumbnail_exist = 0
            // showing the default video thumbnail
            'ffmpeg-status' => false,
            // this is the "play" icon inserted on the video thumbnail
            'videoPlayWatermarkUrl' => public_path('/img/videoplay4.png'),

            // this insert a watermark on the video using ffmpeg, if false, the video is not watermarked
            'ffmpeg-watermark' => false, //insert watermark using laravel ffmpeg and render video again, false dont inser watermark in
            'videoWaterMarkName' => 'watermark_video.png', //watermark video must be located on public/img/watermark_video.png
        ],
        'img' =>
        [   'avatar' => '/img/avatar.png', //default avatar url location
            'backgroundLogo' => '/img/backgroundLogo.jpg',
            'logoIcon' => '/img/logoIcon.png', //default icon location
            'url' => '',  //   /cbpw2.22l/public/ is the htdocs proyect folder // in production you can delete it and just write /public/
            'driver' => 'imagick', //imagick or default gd

            'resize' => false,  //resize image (if false image upload at original size)
            'resizeWidth' => 720,
            'resizeHeight' => 720,
            'watermark' => false, //inser watermark on image
            'watermarkUrl' => public_path('/img/watermark.png'),
            'thumbnailsAlbumsFit' => false, //generate a thumbnailsAlbumSize crop thumbnail
            'thumbnailsAlbumSize' => 200, //uses only when avatarFit is false (dinamic resize based on width size)
            'thumbnailsAlbumQuality' => 100,
            'thumbnailsAlbumSizeWidth' => 200, //fit album thumbnail
            'thumbnailsAlbumSizeHeight' => 200, //fit album thumbnail

            'avatarResize' => false,  //resize image (if false image upload at original size)
            'avatarResizeWidth' => 720,
            'avatarResizeHeight' => 720,
            'avatarWatermark' => false, //inser watermark on image
            'avatarWatermarkUrl' => public_path('/img/watermark.png'),
            'thumbnailsAvatarFit' => false, //generate a thumbnailsAlbumSize crop thumbnail
            'thumbnailsAvatarSize' => 200, //uses only when AvatarFit is false (dinamic resize based on width size)
            'thumbnailsAvatarQuality' => 100,
            'thumbnailsAvatarWidth' => 180, //fit avatar index
            'thumbnailsAvatarHeight' => 305, //fit avatar index
            'thumbnailsAvatarWidth-b' => 200, //fit avatar profile
            'thumbnailsAvatarHeight-b' => 200, //fit avatar profile

        ],
        'albumType' =>
        [
            'media' => 0,
            'embedvideo' => 1,
        ],
    'engine' =>
        [
            'nameext' => 'cyberpunkwaifus.xyz',
            'name' => 'Cyberpunkwaifus',
            'version' => '2.22360',
            'date' => '12/27/2021',
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
