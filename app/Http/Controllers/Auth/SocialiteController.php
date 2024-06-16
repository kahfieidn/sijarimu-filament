<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    //

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $socialUser = Socialite::driver('google')->user();

        $registeredUser = User::where('google_id', $socialUser->id)->first();

        if (!$registeredUser) {
            if (User::where('email', $socialUser->email)->exists()) {
                $user = User::where('email', $socialUser->email)->first();
                $user->update([
                    'google_id' => $socialUser->id,
                ], [
                    'google_token' => $socialUser->token,
                    'google_refresh_token' => $socialUser->refreshToken,
                ]);
                Auth::login($user);
            } else {
                $user = User::updateOrCreate([
                    'google_id' => $socialUser->id,
                ], [
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    'password' => Hash::make('password'),
                    'google_token' => $socialUser->token,
                    'google_refresh_token' => $socialUser->refreshToken,
                ]);
                Auth::login($user);
            }

            return redirect('/app');
        }

        Auth::login($registeredUser);

        return redirect('/app');
    }
}
