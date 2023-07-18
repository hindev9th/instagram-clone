<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $userId = auth()->user()->following()->pluck('profiles.user_id')->push($user->id);

        $posts = Post::whereIn('user_id',$userId)
            ->with('comments','likes')
            ->latest()
            ->paginate(5);

        $posts->each(function ($post) use ($user) {
            $post->isLiked = $user->likes->contains($post->id);
        });
        return $posts;
    }



    public function store(Request $request)
    {
        $imagePath = $request['image']->store('/uploads','public');

        $post = auth()->user()->posts()->create([
            'caption' => $request['caption'],
            'image' => $imagePath,
        ]);

        return $post->load('user','comments','likes');
    }

    public function show(Post $post)
    {
        $post = $post->load('comments','likes');
        $post->isLiked = auth()->user()->likes->contains($post->id);
        return view('posts.show',compact('post'));
    }

    public function destroy(Post $post)
    {
        return $post->delete();
    }
}
