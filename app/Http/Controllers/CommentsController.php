<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(Post $post)
    {
        $data = \request()->validate([
            'user_id' => '',
            'comment' => 'required',
        ]);
        $post->comments()->create($data);

        return redirect(route('post.show',['post' => $post->id]));
    }
}
