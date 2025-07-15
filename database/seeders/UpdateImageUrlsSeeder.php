<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateImageUrlsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entries = DB::table('images')
            ->where('url', 'like', '%/storage/images/%')
            ->get();

        $search = '/storage/images/';
        $replace = 'https://' . config('filesystems.disks.s3.bucket') . '.' . config('filesystems.disks.s3.region') . '.cdn.digitaloceanspaces.com/' . config('filesystems.disks.s3.upload_folder') . '/';

        foreach ($entries as $entry) {
            $updatedContent = str_replace($search, $replace, $entry->url);

            // Update the entry in the database
            DB::table('images')
                ->where('id', $entry->id)
                ->update(['url' => $updatedContent]);
        }
    }
}
