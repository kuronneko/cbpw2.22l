<?php

namespace App\Services;

use App\Models\Stat;
use App\Models\User;
use App\Models\Album;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Lakshmaji\Thumbnail\Facade\Thumbnail;
use Intervention\Image\ImageManagerStatic;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;

class AvatarService
{
    public static function configureImageDriver()
    {
        if (config('myconfig.img.driver') == 'imagick') {
            ImageManagerStatic::configure(['driver' => 'imagick']);
        }
    }

    public static function hasAdminPrivileges()
    {
        $userType = auth()->user()->type;
        return in_array($userType, [
            config('myconfig.privileges.admin++'),
            config('myconfig.privileges.admin+++'),
            config('myconfig.privileges.super')
        ]);
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

    public static function processImage($document, $userId, $newFilename, $websiteTag, $imgWaterMarkPath)
    {
        self::checkExistingFiles($document, $userId, $websiteTag, $newFilename);

        $mainFileName = $websiteTag . $newFilename . '.' . $document->getClientOriginalExtension();
        $thumbFileName = $websiteTag . $newFilename . '_thumb.' . $document->getClientOriginalExtension();
        $thumbbFileName = $websiteTag . $newFilename . '_thumb-b.' . $document->getClientOriginalExtension();

        // Determine storage paths
        if (config('filesystems.default') === 's3') {
            self::createTempFolder();
            $mainImagePath = public_path('/storage/temp/' . $mainFileName);
            $thumbImagePath = public_path('/storage/temp/' . $thumbFileName);
            $thumbbImagePath = public_path('/storage/temp/' . $thumbbFileName);
        } else {
            self::createDirectory($userId);
            $mainImagePath = public_path('/storage/images/' . 'profile_' . $userId . '/' . $mainFileName);
            $thumbImagePath = public_path('/storage/images/' . 'profile_' . $userId . '/' . $thumbFileName);
            $thumbbImagePath = public_path('/storage/images/' . 'profile_' . $userId . '/' . $thumbbFileName);
        }

        $imgResized = self::resizeImage($document);

        if (config('myconfig.img.avatarWatermark') == true) {
            $imgResized = self::addWatermarkToImage($imgResized, $imgWaterMarkPath);
            $imgResized->save($mainImagePath, 100);
        } else {
            $imgResized->save($mainImagePath, 100);
        }

        $imgResizedThumb = self::generateImageThumbnails(
            $imgResized,
            $document->getClientOriginalExtension(),
            $thumbImagePath,
        );
        $imgResizedThumb->save($thumbImagePath, config('myconfig.img.thumbnailsAvatarQuality'));

        $imgResizedThumbb = self::generateImageThumbnailsb(
            $imgResized,
            $document->getClientOriginalExtension(),
            $thumbbImagePath,
        );
        $imgResizedThumbb->save($thumbbImagePath, config('myconfig.img.thumbnailsAvatarQuality'));

        // Upload to S3 if configured, otherwise return local storage URL
        if (config('filesystems.default') === 's3') {
            self::uploadImageToS3($mainImagePath, $mainFileName, $userId);
            self::uploadImageToS3($thumbbImagePath, $thumbbFileName, $userId);
            return self::uploadImageToS3($thumbImagePath, $thumbFileName, $userId);
        } else {
            return '/storage/images/' . 'profile_' . $userId . '/' . $thumbFileName;
        }
    }

    public static function uploadImageToS3($imagePath, $fileName, $userId)
    {
        // Upload the image to S3
        $s3Path = Storage::putFileAs(
            config('filesystems.disks.s3.upload_folder') . '/profile_' . $userId,
            new \Illuminate\Http\File($imagePath),
            $fileName,
            'public'
        );

        // Generate the CDN link
        $cdnLink = str_replace(
            config('filesystems.disks.s3.region') . '.digitaloceanspaces.com',
            config('filesystems.disks.s3.region') . '.cdn.digitaloceanspaces.com',
            Storage::disk('s3')->url($s3Path)
        );

        // $cdnLinkWithoutExtension = pathinfo($cdnLink, PATHINFO_DIRNAME) . '/' . pathinfo($cdnLink, PATHINFO_FILENAME);

        // Delete the local file
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return $cdnLink;
    }

    public static function createDirectory($userId)
    {
        try {
            $path = public_path('/storage/images/' . 'profile_' . $userId);
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            return true;
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public static function checkExistingFiles($photo, $userId, $websiteTag, $newFilename)
    {
        $extension = $photo->getClientOriginalExtension();
        $basePath = public_path('/storage/images/' . 'profile_' . $userId . '/' . $websiteTag . $newFilename);

        return !file_exists($basePath . '_thumb.' . $extension) &&
            !file_exists($basePath . '.' . $extension) &&
            !file_exists($basePath . 'thumb-b.' . $extension) &&
            !User::where('avatar', '/storage/images/' . 'profile_' . $userId . '/' . $websiteTag . $newFilename . '_thumb.' . $extension)->where('id', $userId)->first();
    }


    public static function resizeImage($document)
    {
        try {
            // Get the file path - handle both local and S3 uploaded files
            $filePath = $document->getRealPath() ?: $document->path();

            // Verify the file path exists and is readable
            if (!$filePath || !is_readable($filePath)) {
                throw new \Exception('Image file is not readable: ' . ($filePath ?: 'unknown path'));
            }

            if (config('myconfig.img.resize') == true) {
                $image = ImageManagerStatic::make($filePath);
                if (($image->width() > $image->height()) || ($image->width() == $image->height())) {
                    return $image->resize(config('myconfig.img.resizeWidth'), null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->resizeCanvas(config('myconfig.img.resizeWidth'), null);
                } else {
                    return $image->resize(null, config('myconfig.img.resizeHeight'), function ($constraint) {
                        $constraint->aspectRatio();
                    })->resizeCanvas(null, config('myconfig.img.resizeHeight'));
                }
            } else {
                return ImageManagerStatic::make($filePath);
            }
        } catch (\Exception $e) {
            throw new \Exception('Failed to process image: ' . $e->getMessage());
        }
    }

    public static function addWatermarkToImage($imgResized, $imgWaterMarkPath)
    {
        $width = $imgResized->width();
        $height = $imgResized->height();
        $watermarkSize = ($width >= $height) ? config('myconfig.img.avatarWaterMarkSizeWidth') : config('myconfig.img.avatarWaterMarkSizeHeight');

        if (($width > $height) || ($width == $height)) {
            return $imgResized->insert(
                ImageManagerStatic::make($imgWaterMarkPath)->resize(
                    round($width / $watermarkSize),
                    null,
                    function ($constraint) {
                        $constraint->aspectRatio();
                    }
                )->resizeCanvas(
                    round($width / $watermarkSize),
                    null
                )->opacity(config('myconfig.img.avatarWaterMarkOpacity')),
                'center'
            );
        } else {
            return $imgResized->insert(
                ImageManagerStatic::make($imgWaterMarkPath)->resize(
                    round($width / $watermarkSize),
                    null,
                    function ($constraint) {
                        $constraint->aspectRatio();
                    }
                )->resizeCanvas(
                    round($width / $watermarkSize),
                    null
                )->opacity(config('myconfig.img.avatarWaterMarkOpacity')),
                'center'
            );
        }
    }

    public static function generateImageThumbnailsb($imgResized, $extension, $basePath)
    {
        if (config('myconfig.img.thumbnailsAvatarFit') == true) {
            return ImageManagerStatic::make($imgResized)->fit(
                config('myconfig.img.thumbnailsAvatarWidth-b'),
                config('myconfig.img.thumbnailsAvatarHeight-b')
            );
        } else {
            return ImageManagerStatic::make($imgResized)->resize(
                config('myconfig.img.thumbnailsAvatarSize'),
                null,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            )->resizeCanvas(config('myconfig.img.thumbnailsAvatarSize'), null);
        }
    }
    public static function generateImageThumbnails($imgResized, $extension, $basePath)
    {
        if (config('myconfig.img.thumbnailsAvatarFit') == true) {
            return ImageManagerStatic::make($imgResized)->fit(
                config('myconfig.img.thumbnailsAvatarWidth'),
                config('myconfig.img.thumbnailsAvatarHeight')
            );
        } else {
            return ImageManagerStatic::make($imgResized)->resize(
                config('myconfig.img.thumbnailsAvatarSize'),
                null,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            )->resizeCanvas(config('myconfig.img.thumbnailsAvatarSize'), null);
        }
    }

    public static function updateUserAvatar($userId, $url)
    {
        $user = User::findOrFail($userId);

        if ($user->avatar != config('myconfig.img.avatar')) {
            DeleteImagesService::deleteAvatarImages($user);
        }

        $user->avatar = $url;

        $user->update();
    }
}
