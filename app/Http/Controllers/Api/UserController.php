<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function auth()
    {
        $userId =  auth()->id();
        return User::where('id',$userId)->withCount('following')->first();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function suggested()
    {
        $user = auth()->user();
        $userId = $user->following()->pluck('profiles.user_id')->push($user->id);

        return User::whereNotIn('id', $userId)
            ->inRandomOrder()
            ->paginate(10);
    }

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'password' => 'required|string',
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (bcrypt($request['password']) === $user->password){
            return ['status' => 'Current Password is Invalid'];
        }

        $user->update([
            'password' => bcrypt($request['new_password'])
        ]);
        return ['status' => 'Change password success.'];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
           'username' =>  ['required', 'string', 'regex:/^[a-z0-9.]+$/', 'max:255', 'unique:users'],
        ], [
            'username.regex' => 'The input string can only contain lowercase letters, numbers, and dots.',
        ]);

        $user = $request->user();
        return $user->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
