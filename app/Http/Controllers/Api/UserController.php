<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of suggested users
     *
     * @return mixed
     */
    public function suggested()
    {
        $user = auth()->user();
        $userId = $user->following()->pluck('profiles.user_id')->push($user->id);

        return User::whereNotIn('id', $userId)
            ->inRandomOrder()
            ->paginate(10);
    }

    /**
     * Search users by name or username or email
     *
     * @param $search
     * @return mixed
     */
    public function search($search)
    {
        $user = auth()->user();
        $strSearch = '%' . $search . '%';
        return User::where('id', '!=', $user->id)
            ->where(function ($query) use ($strSearch) {
                $query->where('name', 'like', $strSearch)
                    ->orWhere('username', 'like', $strSearch)
                    ->orWhere('email', 'like', $strSearch);
            })
            ->get();
    }

    /**
     * @param User $user
     * @return User
     */
    public function show(User $user)
    {
        $user = $user->loadCount('posts','following')->load(['posts' => function ($query){
            $query->latest()->limit(3);
        }]);
        $user->followers_count = $user->profile->followers->count();
        return $user;
    }


}
