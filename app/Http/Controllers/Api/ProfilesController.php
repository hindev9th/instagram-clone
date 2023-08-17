<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{

    /**
     * show data profile of user by username
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\View\View|object
     */
    public function index(User $user)
    {
        $user->loadCount('following','posts');
        $user->followers_count = $user->profile->followers->count();
        return $user;
    }

    public function posts(User $user)
    {
        return $user->posts()->paginate(15);
    }

    /**
     * Edit profile of user by user_id
     *
     * @param User $user
     * @return \Illuminate\Contracts\Auth\Authenticatable
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit()
    {
        return auth()->user();
    }

    /**
     * update profile of user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $data = [
            'title' => $request['title'],
            'description' => $request['description'],
        ];
        if ($request['image']) {
            $imagePath = \request('image')->store('/uploads', 'public');
            $data['image'] = $imagePath;
        }

        $user->profile->update($data);

        return response()->json('update success');
    }
}
