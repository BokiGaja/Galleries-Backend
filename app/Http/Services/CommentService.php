<?php


namespace App\Http\Services;


use App\Comment;

class CommentService
{
    public static function createComment($commentData)
    {
        $newComment = new Comment();
        $newComment->content = $commentData->content;
        $newComment->gallery_id = $commentData->gallery_id;
        $newComment->user_id = $commentData->user_id;
        $newComment->save();
    }
}