<?php

namespace App\Services;

use App\Models\Stat;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Lakshmaji\Thumbnail\Facade\Thumbnail;
use Intervention\Image\ImageManagerStatic;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;

class ImageService
{
    public static function validateRequest(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:mp4,webm,gif,png,jpg,jpeg|max:10240'
        ]);
    }

    public static function checkUserPermissions($albumFound, $userId)
    {
        return ($albumFound->user->id == $userId && (auth()->user()->type == config('myconfig.privileges.admin++') || auth()->user()->type == config('myconfig.privileges.admin+++'))) || auth()->user()->type == config('myconfig.privileges.super');
    }

    public static function createDirectoryIfNotExists($userId, $albumId)
    {
        if (!file_exists(public_path('/storage/images/' . 'profile_' . $userId . '/' . $albumId))) {
            mkdir(public_path('/storage/images/' . 'profile_' . $userId . '/' . $albumId), 0755, true);
        }
    }

    public static function fileExists($userId, $albumId, $websiteTag, $newFilename, $extension, $url)
    {
        if (config('filesystems.default') === 's3') {
            $s3Url = str_replace('/storage/images/', 'https://' . config('filesystems.disks.s3.bucket') . '.' . config('filesystems.disks.s3.region') . '.cdn.digitaloceanspaces.com/', $url);
            return Image::where('url', $s3Url)->where('album_id', $albumId)->first();
        } else {
            return file_exists(public_path('/storage/images/' . 'profile_' . $userId . '/' . $albumId . '/' . $websiteTag . $newFilename . '.' . $extension)) || Image::where('url', $url)->where('album_id', $albumId)->first();
        }
    }

    public static function insertImageData($albumFound, $document, $url, $thumbnailExist = 1)
    {
        $image = new Image();
        $image->album_id = $albumFound->id;
        $image->url = $url;
        $image->ext = $document->getClientOriginalExtension();
        $image->size = $document->getSize();
        $image->basename = $document->getClientOriginalName();
        $image->ip = UtilsService::getClientIp();
        $image->tag = "";
        $image->thumbnail_exist = $thumbnailExist;
        $image->save();
    }

    public static function updateStatistics($albumFound, $document)
    {
        $stat = Stat::where('album_id', $albumFound->id)->first();
        if ($stat) {
            $stat->size += $document->getSize();
            if (self::isVideo($document)) {
                $stat->qvideo += 1;
            } else {
                $stat->qimage += 1;
            }
            $stat->save();
            if (Auth::user()->type != 5) {
                $albumFound->touch();
            }
        } else {
            self::createNewStat($albumFound, $document);
        }
    }

    public static function createNewStat($albumFound, $document)
    {
        $stat = new Stat();
        $stat->album_id = $albumFound->id;
        $stat->size = $document->getSize();
        if (self::isVideo($document)) {
            $stat->qvideo = 1;
            $stat->qimage = 0;
        } else {
            $stat->qimage = 1;
            $stat->qvideo = 0;
        }
        $stat->qcomment = 0;
        $stat->qlike = 0;
        $stat->view = 0;
        $stat->save();
        if (Auth::user()->type != 5) {
            $albumFound->touch();
        }
    }

    public static function createTempFolder()
    {
        try {
            $path = public_path('/storage/temp/');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            return true;
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public static function processImage($request, $userId, $albumFound, $websiteTag, $newFilename, $document, $imgWaterMarkPath)
    {
        $mainFileName = $websiteTag . $newFilename . '.' . $document->getClientOriginalExtension();
        $thumbFileName = $websiteTag . $newFilename . '_thumb.' . $document->getClientOriginalExtension();

        // Determine storage paths
        if (config('filesystems.default') === 's3') {
            self::createTempFolder();
            $mainImagePath = public_path('/storage/temp/' . $mainFileName);
            $thumbImagePath = public_path('/storage/temp/' . $thumbFileName);
        } else {
            self::createDirectoryIfNotExists($userId, $albumFound->id);
            $mainImagePath = public_path('/storage/images/' . 'profile_' . $userId . '/' . $albumFound->id . '/' . $mainFileName);
            $thumbImagePath = public_path('/storage/images/' . 'profile_' . $userId . '/' . $albumFound->id . '/' . $thumbFileName);
        }

        $imgResized = self::resizeImage($request, $document);

        if (config('myconfig.img.watermark') == true) {
            $imgResized = self::addWatermarkToImage($imgResized, $imgWaterMarkPath);
            $imgResized->save($mainImagePath, 100);
        } else {
            $imgResized->save($mainImagePath, 100);
        }

        $imgResizedThumb = self::generateImageThumbnails($imgResized);
        $imgResizedThumb->save($thumbImagePath, config('myconfig.img.thumbnailsAlbumQuality'));

        // Upload to S3 if configured, otherwise return local storage URL
        if (config('filesystems.default') === 's3') {
            // Upload thumbnail to S3
            self::uploadImageToS3($thumbImagePath, $thumbFileName, $albumFound->id, $userId);
            // Upload main image to S3
            return self::uploadImageToS3($mainImagePath, $mainFileName, $albumFound->id, $userId);
        } else {
            return Storage::url('public/images/profile_' . $userId . '/' . $albumFound->id . '/' . pathinfo($mainFileName, PATHINFO_FILENAME));
        }
    }

    public static function uploadImageToS3($imagePath, $fileName, $albumId, $userId)
    {
        // Upload the image to S3
        $s3Path = Storage::putFileAs(
            config('filesystems.disks.s3.upload_folder') . '/profile_' . $userId . '/' . $albumId,
            new \Illuminate\Http\File($imagePath),
            $fileName,
            'public'
        );

        // Generate the CDN link
        $cdnLink = 'https://' . config('filesystems.disks.s3.bucket') . '.' . config('filesystems.disks.s3.region') . '.cdn.digitaloceanspaces.com/' . $s3Path;

        $cdnLinkWithoutExtension = pathinfo($cdnLink, PATHINFO_DIRNAME) . '/' . pathinfo($cdnLink, PATHINFO_FILENAME);

        // Delete the local file
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return $cdnLinkWithoutExtension;
    }

    public static function uploadVideoToS3($videoPath, $fileName, $albumId, $userId)
    {
        // Upload the video to S3
        $s3Path = Storage::putFileAs(
            config('filesystems.disks.s3.upload_folder') . '/profile_' . $userId . '/' . $albumId,
            new \Illuminate\Http\File($videoPath),
            $fileName,
            'public'
        );

        // Generate the CDN link
        $cdnLink = 'https://' . config('filesystems.disks.s3.bucket') . '.' . config('filesystems.disks.s3.region') . '.cdn.digitaloceanspaces.com/' . $s3Path;

        $cdnLinkWithoutExtension = pathinfo($cdnLink, PATHINFO_DIRNAME) . '/' . pathinfo($cdnLink, PATHINFO_FILENAME);

        // Delete the local file
        if (file_exists($videoPath)) {
            unlink($videoPath);
        }

        return $cdnLinkWithoutExtension;
    }

    public static function resizeImage($request, $document)
    {
        if (config('myconfig.img.resize') == true) {
            if ((ImageManagerStatic::make($request->file('file')->getRealPath())->width() > ImageManagerStatic::make($request->file('file')->getRealPath())->height()) || (ImageManagerStatic::make($request->file('file')->getRealPath())->width() == ImageManagerStatic::make($request->file('file')->getRealPath())->height())) {
                return ImageManagerStatic::make($request->file('file')->getRealPath())->resize(config('myconfig.img.resizeWidth'), null, function ($constraint) {
                    $constraint->aspectRatio();
                })->resizeCanvas(config('myconfig.img.resizeWidth'), null);
            } else {
                return ImageManagerStatic::make($request->file('file')->getRealPath())->resize(null, config('myconfig.img.resizeHeight'), function ($constraint) {
                    $constraint->aspectRatio();
                })->resizeCanvas(null, config('myconfig.img.resizeHeight'));
            }
        } else {
            return ImageManagerStatic::make($request->file('file')->getRealPath());
        }
    }

    public static function addWatermarkToImage($imgResized, $imgWaterMarkPath)
    {
        if (($imgResized->width() > $imgResized->height()) || ($imgResized->width() == $imgResized->height())) {
            return $imgResized->insert(
                ImageManagerStatic::make($imgWaterMarkPath)->resize(
                    round($imgResized->width() / config('myconfig.img.albumWaterMarkSizeWidth')),
                    null,
                    function ($constraint) {
                        $constraint->aspectRatio();
                    }
                )->resizeCanvas(
                    round($imgResized->width() / config('myconfig.img.albumWaterMarkSizeWidth')),
                    null
                )->opacity(config('myconfig.img.albumWaterMarkOpacity')),
                'center'
            );
        } else {
            return $imgResized->insert(
                ImageManagerStatic::make($imgWaterMarkPath)->resize(
                    round($imgResized->width() / config('myconfig.img.albumWaterMarkSizeHeight')),
                    null,
                    function ($constraint) {
                        $constraint->aspectRatio();
                    }
                )->resizeCanvas(
                    round($imgResized->width() / config('myconfig.img.albumWaterMarkSizeHeight')),
                    null
                )->opacity(config('myconfig.img.albumWaterMarkOpacity')),
                'center'
            );
        }
    }

    public static function generateImageThumbnails($imgResized)
    {
        if (config('myconfig.img.thumbnailsAlbumsFit') == true) {
            return ImageManagerStatic::make($imgResized)->fit(
                config('myconfig.img.thumbnailsAlbumSizeWidth'),
                config('myconfig.img.thumbnailsAlbumSizeHeight')
            );
        } else {
            return ImageManagerStatic::make($imgResized)->resize(
                config('myconfig.img.thumbnailsAlbumSize'),
                null,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            )->resizeCanvas(config('myconfig.img.thumbnailsAlbumSize'), null);
        }
    }

    /////////////////////
    // VIDEO FUNCTIONS //
    /////////////////////

    public static function uploadMainFile($request, $userId, $albumFound, $websiteTag, $newFilename, $document)
    {
        if (config('filesystems.default') === 's3') {
            // Create temp folder and store locally first for FFmpeg processing
            self::createTempFolder();
            $tempFileName = $websiteTag . $newFilename . '_temp.' . $document->getClientOriginalExtension();
            $request->file('file')->storeAs('temp', $tempFileName, 'public');
        } else {
            $request->file('file')->storeAs('public/images/' . 'profile_' . $userId . '/' . $albumFound->id, $websiteTag . $newFilename . '_temp.' . $document->getClientOriginalExtension());
        }
    }

    public static function isVideo($document)
    {
        return in_array($document->getClientOriginalExtension(), ["mp4", "webm"]);
    }

    public static function processVideo($request, $userId, $albumFound, $websiteTag, $newFilename, $document)
    {
        $finalVideoFileName = $websiteTag . $newFilename . '.' . $document->getClientOriginalExtension();

        if (config('myconfig.patch-pre-ffmpeg.ffmpeg-watermark') == true) {
            self::uploadMainFile($request, $userId, $albumFound, $websiteTag, $newFilename, $document);
            self::addWatermarkToVideo($userId, $albumFound, $websiteTag, $newFilename, $document);
        } else {
            if (config('filesystems.default') === 's3') {
                // Create temp folder for S3 processing
                self::createTempFolder();
                $tempVideoPath = public_path('/storage/temp/' . $finalVideoFileName);
                $request->file('file')->storeAs('temp', $finalVideoFileName, 'public');

                // Upload to S3 and get the URL
                $videoUrl = self::uploadVideoToS3($tempVideoPath, $finalVideoFileName, $albumFound->id, $userId);
            } else {
                $request->file('file')->storeAs('public/images/' . 'profile_' . $userId . '/' . $albumFound->id, $finalVideoFileName);
            }
        }

        // Upload watermarked video to S3 if configured
        if (config('myconfig.patch-pre-ffmpeg.ffmpeg-watermark') == true && config('filesystems.default') === 's3') {
            $videoPath = public_path('/storage/temp/' . $finalVideoFileName);
            $videoUrl = self::uploadVideoToS3($videoPath, $finalVideoFileName, $albumFound->id, $userId);
        }

        if (config('myconfig.patch-pre-ffmpeg.ffmpeg-status') == true) {
            self::generateVideoThumbnail($userId, $albumFound, $websiteTag, $newFilename, $document);

            // Return the video URL for S3, otherwise return local storage URL pattern
            if (config('filesystems.default') === 's3') {
                return isset($videoUrl) ? $videoUrl : null;
            }
        }

        // Return URL for non-S3 storage
        if (config('filesystems.default') !== 's3') {
            return Storage::url('public/images/profile_' . $userId . '/' . $albumFound->id . '/' . pathinfo($finalVideoFileName, PATHINFO_FILENAME));
        }

        return isset($videoUrl) ? $videoUrl : null;
    }

    public static function addWatermarkToVideo($userId, $albumFound, $websiteTag, $newFilename, $document)
    {
        $format = $document->getClientOriginalExtension() == "mp4" ? new \FFMpeg\Format\Video\X264 : new \FFMpeg\Format\Video\WebM;

        if (config('filesystems.default') === 's3') {
            // Process with temp files for S3
            $tempInputPath = '/temp/' . $websiteTag . $newFilename . '_temp.' . $document->getClientOriginalExtension();
            $tempOutputPath = '/temp/' . $websiteTag . $newFilename . '.' . $document->getClientOriginalExtension();

            FFMpeg::fromDisk('public')
                ->open($tempInputPath)
                ->addWatermark(function (WatermarkFactory $watermark) {
                    $watermark->fromDisk('assets')
                        ->open(config('myconfig.patch-pre-ffmpeg.videoWaterMarkName'))
                        ->horizontalAlignment(WatermarkFactory::CENTER, intval(array(-150, 0, 150)[array_rand(array(-150, 0, 150))]))
                        ->verticalAlignment(WatermarkFactory::CENTER, intval(array(-350, -250, 0, 250, 350)[array_rand(array(-350, -250, 0, 250, 350))]));
                })
                ->export()
                ->toDisk('public')
                ->inFormat($format)
                ->save($tempOutputPath);

            // Clean up temp input file
            Storage::disk('public')->delete($tempInputPath);
        } else {
            // Original local processing
            FFMpeg::fromDisk('public')
                ->open('/images/' . 'profile_' . $userId . '/' .  $albumFound->id . '/' . $websiteTag . $newFilename . '_temp.' . $document->getClientOriginalExtension())
                ->addWatermark(function (WatermarkFactory $watermark) {
                    $watermark->fromDisk('assets')
                        ->open(config('myconfig.patch-pre-ffmpeg.videoWaterMarkName'))
                        ->horizontalAlignment(WatermarkFactory::CENTER, intval(array(-150, 0, 150)[array_rand(array(-150, 0, 150))]))
                        ->verticalAlignment(WatermarkFactory::CENTER, intval(array(-350, -250, 0, 250, 350)[array_rand(array(-350, -250, 0, 250, 350))]));
                })
                ->export()
                ->toDisk('public')
                ->inFormat($format)
                ->save('/images/' . 'profile_' . $userId . '/' .  $albumFound->id . '/' . $websiteTag . $newFilename . '.' . $document->getClientOriginalExtension());
            Storage::disk('public')->delete('/images/' . 'profile_' . $userId . '/' . $albumFound->id . '/' . $websiteTag . $newFilename . '_temp.' . $document->getClientOriginalExtension());
        }
    }

    public static function generateVideoThumbnail($userId, $albumFound, $websiteTag, $newFilename, $document)
    {
        $videoFileName = $websiteTag . $newFilename . '.' . $document->getClientOriginalExtension();
        $thumbnailImageName = $websiteTag . $newFilename . '_thumb.jpg';

        if (config('filesystems.default') === 's3') {
            // For S3, work with temp files
            $videoPath = public_path('/storage/temp/' . $videoFileName);
            $thumbnailPath = public_path('/storage/temp/');
            $thumbnailFullPath = public_path('/storage/temp/' . $thumbnailImageName);
        } else {
            // For local storage
            $videoPath = public_path('/storage/images/' . 'profile_' . $userId . '/' .  $albumFound->id . '/' . $videoFileName);
            $thumbnailPath = public_path('/storage/images/' . 'profile_' . $userId . '/' . $albumFound->id . '/');
            $thumbnailFullPath = public_path('/storage/images/' . 'profile_' . $userId . '/' . $albumFound->id . '/' . $thumbnailImageName);
        }

        $timeToImage = 2;
        Thumbnail::getThumbnail($videoPath, $thumbnailPath, $thumbnailImageName, $timeToImage);

        $videoWaterMarkPath = config('myconfig.patch-pre-ffmpeg.videoPlayWatermarkUrl');
        if (config('myconfig.img.thumbnailsAlbumsFit') == true) {
            ImageManagerStatic::make($thumbnailFullPath)->fit(config('myconfig.img.thumbnailsAlbumSizeWidth'), config('myconfig.img.thumbnailsAlbumSizeHeight'))->insert($videoWaterMarkPath, 'center')->save($thumbnailFullPath, config('myconfig.img.thumbnailsAlbumQuality'));
        } else {
            ImageManagerStatic::make($thumbnailFullPath)->resize(config('myconfig.img.thumbnailsAlbumSize'), null, function ($constraint) {
                $constraint->aspectRatio();
            })->resizeCanvas(config('myconfig.img.thumbnailsAlbumSize'), null)->insert($videoWaterMarkPath, 'center')->save($thumbnailFullPath, config('myconfig.img.thumbnailsAlbumQuality'));
        }

        // Upload thumbnail to S3 if configured
        if (config('filesystems.default') === 's3') {
            return self::uploadImageToS3($thumbnailFullPath, $thumbnailImageName, $albumFound->id, $userId);
        }

        return null;
    }
}
