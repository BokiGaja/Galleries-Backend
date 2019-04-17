<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Services\CreationService;
use App\Http\Services\ValidationService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = ValidationService::validateComment($request);
        if (!is_string($validator)) {
            CreationService::createComment($request);
        } else {
            return response()->json(['error' => $validator]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comments = Comment::where('gallery_id', $id)->with('user')->get();
        return $comments;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
    }
}
