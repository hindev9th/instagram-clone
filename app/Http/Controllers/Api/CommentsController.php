<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comments;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function index(Post $post)
    {
        return Comments::where('post_id',$post->id)
            ->paginate(5);
    }

    public function store(Request $request,Post $post)
    {
        $comment = $post->comments()->create([
            'user_id' => $request['user_id'],
            'comment' => $request['comment'],
        ]);

        return $comment->load(['user' => function ($query){
            $query->select('id','name','username');
        }]);
    }
}
