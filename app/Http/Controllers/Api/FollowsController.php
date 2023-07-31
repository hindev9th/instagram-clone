<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class FollowsController extends Controller
{
    public function followers(User $user)
    {
        return $user->profile->followers()->paginate(5);
    }

    public function following(User $user)
    {
        $userId = $user->following()->pluck('profiles.user_id');
        return $user->whereIn('id',$userId)->paginate(5);
    }

    public function store(User $user)
    {
        return auth()->user()->following()->toggle($user->profile);
    }
}
