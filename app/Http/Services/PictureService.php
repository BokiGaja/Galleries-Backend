<?php


namespace App\Http\Services;


use App\Picture;

class PictureService
{
    public static function createPicture($pictureUrl, $galleryId)
    {
        $newPicture = new Picture();
        $newPicture->imageUrl = $pictureUrl;
        $newPicture->gallery_id = $galleryId;
        $newPicture->save();
    }
}