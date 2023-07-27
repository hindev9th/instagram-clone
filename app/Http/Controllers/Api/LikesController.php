<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;

class LikesController extends Controller
{
    public function index(Post $post)
    {
        $users = $post->likes()->paginate(5);
        $users->each(function ($user){
            $user->isFollowing = auth()->user()->following->contains($user->id);
        });
        return $users;
    }

    public function loadUserLikeComment(Comment $comment)
    {
        $users = $comment->likes()->paginate(5);
        $users->each(function ($user){
            $user->isFollowing = auth()->user()->following->contains($user->id);
        });
        return $users;
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
