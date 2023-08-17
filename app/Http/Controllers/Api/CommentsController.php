<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function index(Post $post)
    {
        return $post->comments()->withCount('likes','replies')->paginate(5);
    }

    public function loadReplies(Comment $comment)
    {
        return $comment->replies()->withCount('likes','replies')->paginate(5);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $data = array_merge($request->all(),['user_id' => $user->id]) ;
        $comment = Comment::create($data);
        return $comment->load('user');
    }


    public function update(Request $request,Comment $comment)
    {
        $comment->update($request->all());
        return $comment;
    }

    public function destroy(Comment $comment)
    {
        return $comment->delete();
    }
}
