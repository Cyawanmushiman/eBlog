<?php

namespace App\Services;

class ImageService
{
    public static function upload($eyeCatchImage, $folderfile)
    {
        $original = $eyeCatchImage->getClientOriginalName();
        $fileName  = date('Ymd_His') . '_' . $original;
        $eyeCatchImage->move("storage/public/$folderfile/", $fileName);
        return $fileName;
    }
}
