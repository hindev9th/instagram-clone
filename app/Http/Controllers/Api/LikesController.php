<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

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

    /**
     * check user liked post
     *
     * @param Post $post
     * @return mixed
     */
    public function check(Post $post)
    {
        return auth()->user()->likes->contains($post->id);
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
}
