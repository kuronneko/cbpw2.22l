<?php


return [
    'patch-pre-ffmpeg' =>
        [       // turn off ffmpeg set 9999999 and false
                // enable is 0 and true
            'image-id-less' => 9999999, //this works to fix the no existence of video thumbnail before ffmpeg implementation (0 set all video thumbnails on) and number less than "30" for example, put all 30 elements before with the default video thumbnail (not generate)
            'ffmpeg-status' => false,
        ],
    'img' =>
        [   'avatar' => '/storage/images/avatar.png',
            'url' => '/cbpw2.22l/public/',  // /cbpw2.22l/public/ is the htdocs proyect folder // in production you can delete it and just write /public/
        ],
    'engine' =>
        [
            'name' => 'Cyberpunkwaifus',
            'version' => '2.22080',
            'date' => '7/6/2021',
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
