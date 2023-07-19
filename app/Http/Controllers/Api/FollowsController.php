<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class FollowsController extends Controller
{
    public function followers(User $user)
    {
        $users = $user->profile->followers()->paginate(5);;

        $users->each(function ($user){
            $user->isFollowing = auth()->user()->following->contains($user->id);
        });

        return $users;
    }

    public function following(User $user)
    {
        $profiles = $user->following()->paginate(5);

        $users = $profiles->map(function ($profile) {
            $user = $profile->user;
            $user->isFollowing = auth()->user()->following->contains($profile->user->id);
            return $user;
        });

        return [
            'data' => $users,
            'current_page' => $profiles->currentPage(),
            'last_page' => $profiles->lastPage(),
            'total' => $profiles->total(),
        ];
    }

    public function store(User $user)
    {
        return auth()->user()->following()->toggle($user->profile);
    }
}
