<?php

return [
    'patch-pre-ffmpeg' =>
        [
            'image-id-less' => 0, //this works to fix the no existence of video thumbnail before ffmpeg implementation (0 set all video thumbnails on) and number less than "30" for example, put all 30 elements before with the default video thumbnail (not generate)
            'ffmpeg-status' => true,
        ],
    'img' =>
        [   'avatar' => '/storage/images/avatar.png',
            'url' => '/cbpw2.22l/public/',  //cbpw2.22l is the htdocs proyect folder // in production you can delete it and just write /public/
        ],
    'engine' =>
        [
            'name' => 'Cyberpunkwaifus',
            'version' => '2.22040',
            'date' => '4/27/2021',
        ],
    'privileges' =>
        [
            'banned' => 0,
            'admin' => 1, // normal status when user is register
            'admin++' => 2,
            'super' => 5, // super admin can manager normal users
        ],
];


?>
