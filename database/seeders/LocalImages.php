<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class LocalImages
{
    public static function getRandomFile():SplFileInfo
    {
        return collect(
            File::files(database_path('seeders/local_images'))
        )->random();
    }
}
