<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Firebase\Auth\Token\Exception\InvalidToken;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {
        $data = json_decode($request->getContent());



        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'firebase_uid' => $data->uid,
            'password' => bcrypt($data->password)
        ]);

        // $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json(['user' => $user], 200);
    }

    /**
     * Login
     */

    public function login(Request $request)
    {
        $data = json_decode($request->getContent());

        // Launch Firebase Auth
        $auth = app('firebase.auth');
        // Retrieve the Firebase credential's token
        $idTokenString = $data->firebasetoken;

        try { // Try to verify the firebase credential token with Google
            $verifiedToken = $auth->verifyIdToken($idTokenString);
        } catch (\InvalidArgumentException $e) { // If the token has the wrong format
            return response()->json(
                [
                    'message' => 'Unauthorized - Can\'t parse the token' . $e->getMessage()
                ],
                401
            );
        }

        // Retrieve the UID (User ID) from the verified Firebase credential's token
        $uid = $verifiedToken->claims()->get('sub');

        // Retrieve the user model linked with the Firebase UID
        $user = User::where('firebase_uid', $uid)->first();

        // Here you could check if the user model exist and if not create it
        // For simplicity we will ignore this step

        // Once we got a valid user model
        // Create a Personnal Access Token
        $tokenResult = $user->createToken('Personal Access Token');

        // Store the created token
        $token = $tokenResult->token;

        // Add a expiration date to the token
        $token->expires_at = Carbon::now()->addWeeks(1);

        // Save the token to the user
        $token->save();

        return response()->json([
            "id" => $user->id,
            "access_token" => $tokenResult->accessToken,
            "token_type" => "Bearer",
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ], 200);

        // $data = [
        //     'email' => $request->email,
        //     'password' => $request->password
        // ];

        // if (auth()->attempt($data)) {
        //     /** @var \App\Models\User $user **/
        //     $user = Auth::user();
        //     $token = $user->createToken('LaravelAuthApp')->accessToken;
        //     return response()->json(['token' => $token], 200);
        // } else {
        //     return response()->json(['error' => 'Unauthorised'], 401);
        // }
    }
}
