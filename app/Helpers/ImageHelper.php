<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{

    /**
     * @param $image
     * @param string $path
     * @return false|string
     */
    public static function create($image, string $path)
    {
        return Storage::disk('public')->putFile($path, $image);
    }

}
