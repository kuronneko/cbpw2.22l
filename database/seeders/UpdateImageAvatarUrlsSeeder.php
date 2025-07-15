<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateImageAvatarUrlsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entries = DB::table('users')
            ->where('avatar', 'like', '%/storage/images/%')
            ->get();

        $search = '/storage/images/';
        $replace = 'https://' . config('filesystems.disks.s3.bucket') . '.' . config('filesystems.disks.s3.region') . '.cdn.digitaloceanspaces.com/' . config('filesystems.disks.s3.upload_folder') . '/';

        foreach ($entries as $entry) {
            $updatedContent = str_replace($search, $replace, $entry->avatar);

            // Update the entry in the database
            DB::table('users')
                ->where('id', $entry->id)
                ->update(['avatar' => $updatedContent]);
        }
    }
}
