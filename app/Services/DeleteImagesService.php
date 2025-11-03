<?php

namespace App\Services;

use App\Models\User;
use App\Models\Album;
use Illuminate\Support\Facades\Storage;

class DeleteImagesService
{
    public static function deleteAvatarImages(User $user)
    {
        $parsedUrl = parse_url($user->avatar, PHP_URL_PATH);
        $relativePath = ltrim($parsedUrl, '/');

        if (config('filesystems.default') === 's3') {
            $thumbImage = $relativePath;
            $mainImage = str_replace('_thumb', '', $thumbImage);
            $thumbbImage = str_replace('_thumb', '_thumb-b', $thumbImage);
            Storage::disk('s3')->delete($mainImage);
            Storage::disk('s3')->delete($thumbImage);
            Storage::disk('s3')->delete($thumbbImage);
        } else {
            $productImage = str_replace('/storage', '', $user->avatar); //remove thumbnail
            $productImage2 = str_replace('_thumb', '', $productImage); //remove main file
            $productImage3 = str_replace('_thumb', '_thumb-b', $productImage); //remove thumb b
            Storage::delete('/public' . $productImage);
            Storage::delete('/public' . $productImage2);
            Storage::delete('/public' . $productImage3);
        }
    }

    // this deletes the album folder and all images inside it
    public static function deleteAlbumFolder(Album $album)
    {
        if (config('filesystems.default') === 's3') {
            $folderPath = config('filesystems.disks.s3.upload_folder') . '/profile_' . $album->user->id . '/' . $album->id;
            if (Storage::disk('s3')->exists($folderPath)) {  //check if folder exist
                Storage::disk('s3')->deleteDirectory($folderPath);
            }
        } else {
            $folderPath = 'public/images/' . 'profile_' . $album->user->id . '/' . $album->id;
            if (Storage::exists($folderPath)) {  //check if folder exist
                Storage::deleteDirectory($folderPath);
            }
        }
    }

    // this deletes the user folder and all images inside it
    public static function deleteUserFolder(User $user)
    {
        if (config('filesystems.default') === 's3') {
            $folderPath = config('filesystems.disks.s3.upload_folder') . '/profile_' . $user->id;
            if (Storage::disk('s3')->exists($folderPath)) {  //check if folder exist
                Storage::disk('s3')->deleteDirectory($folderPath);
            }
        } else {
            $folderPath = 'public/images/' . 'profile_' . $user->id;
            if (Storage::exists($folderPath)) {  //check if folder exist
                Storage::deleteDirectory($folderPath);
            }
        }
    }
}
