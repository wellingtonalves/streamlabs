<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
     * Retrieve user
     */
    public function user()
    {
        try {
            return response()->json([
                'message' => 'User info',
                'user' => Auth::user()
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Error on get user',
                'status' => 500
            ], 500);
        }
    }

    /**
     * Redirect user to provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect()
    {
        return Socialite::driver('twitch')->redirect();
    }

    /**
     * Get user info from provider and authenticate
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback()
    {
        try {
            $user = Socialite::driver('twitch')->stateless()->user();

            $userLocal = User::where('email', $user->email)->first();
            if (!$userLocal) {
                $userLocal = User::create([
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'image' => $user->getAvatar(),
                    'provider_id' => $user->getId(),
                    'provider' => 'twitch',
                ]);
            }

            $token = $userLocal->createToken('Twitch')->accessToken;

            return response()->redirectTo('/login?token=' . $token);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Error on authenticate user',
                'status' => 500
            ], 500);
        }
    }

    /**
     * Revoke user
     */
    public function revoke()
    {
        try {
            auth()->user()->token()->revoke();
            return response()->json([
                'message' => 'User revoked'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Error on revoke user',
                'status' => 500
            ], 500);
        }
    }
}
