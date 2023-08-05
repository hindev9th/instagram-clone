<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;

class LikesController extends Controller
{
    public function index(Post $post)
    {
        return $post->likes()->paginate(10);
    }

    public function loadUserLikeComment(Comment $comment)
    {
        return $comment->likes()->paginate(10);
    }


    /**
     * toggle like and unlike
     *
     * @param Post $post
     * @return mixed
     */
    public function store(Post $post)
    {
        return auth()->user()->likes()->toggle($post);
    }

    /**
     * toggle like and unlike comment
     *
     * @param Comment $comment
     * @return mixed
     */
    public function commentStore(Comment $comment)
    {
        return auth()->user()->commentLikes()->toggle($comment);
    }
}
