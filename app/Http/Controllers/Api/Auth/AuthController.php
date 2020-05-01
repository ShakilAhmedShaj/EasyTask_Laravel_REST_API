<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(Request $request)
    {

        $base_url = env('APP_URL');

        $validateData = $request->validate([
            'name' => 'required|max:25',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        //create user
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->save();

        //create a default user profile
        if ($user) {

            $profile = new UserProfile();
            $profile->user_id = $user->id;
            $profile->profile_image = $base_url . "public/storage/profile_image/default_profile.png";
            $profile->profile_image_path = "public/storage/profile_image/default_profile.png";
            $profile->bio = "Hey! this is my default bio. It's a great.";
            $profile->save();
        }

        return response()->json($user, 201);

    }


    public function  login(Request $request){

        $validateData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $login_detail = request(['email','password']);

        if (!Auth::attempt($login_detail)){

            return response()->json([
                'error' => 'Login Failed. Please check your login detail'
            ], 401
            );
        }

        $user = $request->user();

        $tokenResult = $user->createToken('AccessToken');
        $token = $tokenResult->token;
        $token->save();


        return response()->json([
            'access_token' => "Bearer ".$tokenResult->accessToken,
            'token_id'  => $token->id,
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email

        ],200);

    }
}
