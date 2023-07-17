<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikesController extends Controller
{

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
