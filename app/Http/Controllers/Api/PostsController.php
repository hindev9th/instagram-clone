<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

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
            $post->user->isFollowing = auth()->user()->following->contains($post->user_id);
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
        $post->user->isFollowing = auth()->user()->following->contains($post->user_id);
        return $post;
    }

    public function edit(Post $post)
    {

    }

    public function update(Request $request,Post $post)
    {
        $data = [
            'caption' => $request['caption'],
        ];
        if ($request['image'] != null){
            $image = $request['image']->store('/uploads','public');
            $data['image'] = $image;
        }
        $post->update($data);

        return $post;
    }

    public function destroy(Post $post)
    {
        return $post->delete();
    }
}
