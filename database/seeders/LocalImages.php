<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class LocalImages
{
    public static function billboard(): SplFileInfo
    {
        return collect(
            File::files(database_path('seeders/local_images/billboards'))
        )->random();
    }

    public static function campaign(): SplFileInfo
    {
        return collect(
            File::files(database_path('seeders/local_images/campaign_images'))
        )->random();
    }
}
