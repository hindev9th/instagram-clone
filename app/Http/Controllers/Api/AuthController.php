<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        $userId =  auth()->id();
        return User::where('id',$userId)->withCount('following')->first();
    }

    public function login(Request $request)
    {
        return $this->attemptLogin($request);
    }

    protected function attemptLogin(Request $request){
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])){
            $token = Auth::user()->api_token;
            return ['status' => 200 , 'token' => $token];
        }else{
            return ['status' => 401];
        }
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->create($request->all());

        return $this->attemptLogin($request);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'regex:/^[a-z0-9.]+$/', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'username.regex' => 'The input string can only contain lowercase letters, numbers, and dots.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'api_token' => Str::random(60),
        ]);
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
}
