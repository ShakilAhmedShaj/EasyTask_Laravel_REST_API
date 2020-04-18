<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\User;
use App\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{


    public function getUserDetail($id)
    {

        $data = DB::table('users')
            ->where('users.id', '=', $id)
            ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'user_profiles.profile_image',
                'user_profiles.profile_image_path',
                'user_profiles.bio'
            )
            ->first();

        return Response()->json($data, Response::HTTP_OK);
    }

    public function edit(Request $request)
    {
        $base_url = env('APP_URL');

        $user = User::where('id', '=', $request->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        if ($user) {

            $profile = UserProfile::where('user_id', '=', $request->id)->first();

            if ($request->profile_image != '') {
                $user_id = $request->id;
                $imageName = $user_id . "." . $request->profile_image->extension();
                $image_dest_path = public_path("/storage/profile_image");
                $request->profile_image->move($image_dest_path, $imageName);

                $profile->profile_image = $base_url . "/storage/profile_image/" . $imageName;
                $profile->profile_image_path = "/storage/profile_image/" . $imageName;
                $profile->bio = $request->bio;
                $profile->save();

                return Response()->json(['success' => true], Response::HTTP_OK);

            } else {

                $profile->bio = $request->bio;
                $profile->save();

                return Response()->json(['success' => true], Response::HTTP_OK);
            }
        }

    }


}
