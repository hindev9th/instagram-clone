<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProfilesController extends Controller
{

    /**
     * show data profile of user by user_id
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(User $user)
    {
        // check follow return : true | false
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        // set cache posts count (key,time,function)
        $postsCount = Cache::remember(
            'count.posts.' . $user->id,
            now()->addSecond(30),
            function () use ($user) {
            return $user->posts->count();
        });


        // set cache followers count (key,time,function)
        $followersCount = Cache::remember(
            'count.followers.' . $user->id,
            now()->addSecond(30),
            function () use ($user) {
                return $user->profile->followers->count();
            });

        // set cache following count (key,time,function)
        $followingCount = Cache::remember(
            'count.following.' . $user->id,
            now()->addSecond(30),
            function () use ($user) {
                return $user->following->count();
            });

        // get data following
        $usersFollowing = $user->following()->get();

        return view('profiles.index', compact('user','usersFollowing', 'follows','postsCount','followersCount','followingCount'));
    }

    /**
     * Edit profile of user by user_id
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);
        return view('Profiles.edit', compact('user'));
    }

    /**
     * update profile of user after edit by user_id
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(User $user)
    {
        $data = \request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => '',
            'image' => '',
        ]);

        if (\request('image')) {
            $imagePath = \request('image')->store('/uploads', 'public');

            $data = array_merge(
                $data,
                ['image' => $imagePath]
            );
        }

        auth()->user()->profile->update($data);

        return redirect(route('profile.index', ['user' => $user->username]));
    }
}
