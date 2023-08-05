<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
