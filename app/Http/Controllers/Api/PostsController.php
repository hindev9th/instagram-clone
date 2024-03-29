<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostsController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $userId = auth()->user()->following()->pluck('profiles.user_id')->push($user->id);

        $posts = Post::whereIn('user_id',$userId)
            ->withCount('comments','likes')
            ->latest()
            ->paginate(5);

        return $posts;
    }

    public function olds()
    {
        $user = auth()->user();
        $userId = auth()->user()->following()->pluck('profiles.user_id')->push($user->id);

        $posts = Post::whereDate('created_at','<',Carbon::now()->subDays(3))->whereIn('user_id',$userId)
            ->withCount('comments','likes')
            ->latest()
            ->paginate(5);

        return $posts;
    }

    public function suggested(){
        $user = auth()->user();
        $userId = auth()->user()->following()->pluck('profiles.user_id')->push($user->id);

        return Post::whereNotIn('user_id',$userId)
            ->withCount('comments','likes')
            ->inRandomOrder()
            ->latest()
            ->paginate(5);
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
        $post = $post->loadCount('comments','likes');
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
        if ($request['image']){
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
