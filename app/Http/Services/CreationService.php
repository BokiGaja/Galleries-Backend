<?php


namespace App\Http\Services;


use App\Comment;
use App\Gallery;
use App\Picture;

class CreationService
{
    public static function createGallery($galleryData)
    {
        $gallery = new Gallery();
        $gallery->title = $galleryData->title;
        $gallery->description = $galleryData->description;
        $gallery->user_id = $galleryData->user_id;
        $gallery->save();
        return $gallery;
    }

    public static function createPicture($pictureUrl, $galleryId)
    {
        $newPicture = new Picture();
        $newPicture->imageUrl = $pictureUrl;
        $newPicture->gallery_id = $galleryId;
        $newPicture->save();
    }

    public static function createComment($commentData)
    {
        $newComment = new Comment();
        $newComment->content = $commentData->content;
        $newComment->gallery_id = $commentData->gallery_id;
        $newComment->user_id = $commentData->user_id;
        $newComment->save();
        return $newComment;
    }
}