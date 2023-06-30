<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Post::whereIn('user_id',$user)->orWhere('user_id',auth()->user()->id)->with('user')->latest()->paginate(5);

        $rememberUsers = User::where('id','!=',\auth()->user()->id)
            ->whereNotIn('id',$user)
            ->inRandomOrder()
            ->paginate(5);

        return view('posts.index',compact('posts','rememberUsers'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        $data = \request()->validate([
            'caption' => ['required','string'],
            'image' => ['required','image'],
        ]);

        $imagePath = \request('image')->store('/uploads','public');

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        return redirect('/profile/'.\auth()->user()->username);

    }

    public function show(Post $post)
    {
        $like = (\auth()->user()) ? \auth()->user()->likes->contains($post->id) : false;


        return view('posts.show',compact('post','like'));
    }
}
