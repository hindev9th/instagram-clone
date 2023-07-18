<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
    public function followers()
    {
        $users = auth()->user()->followers()->paginate(5);;

        $users->each(function ($user){
            $user->isFollowing = auth()->user()->following->contains($user->id);
        });

        return $users;
    }

    public function following()
    {
        $users = auth()->user()->following()->paginate(5);;

        $users->each(function ($user){
            $user->isFollowing = auth()->user()->following->contains($user->id);
        });

        return $users;
    }

    public function store(User $user)
    {
        return auth()->user()->following()->toggle($user->profile);
    }
}
