<?php


namespace App\Http\Services;


use App\Gallery;

class GalleryService
{
    public function createGallery($galleryData)
    {
        $gallery = new Gallery();
        $gallery->title = $galleryData->title;
        $gallery->description = $galleryData->description;
        $gallery->user_id = $galleryData->user_id;
        $gallery->save();
        return $gallery;
    }
}