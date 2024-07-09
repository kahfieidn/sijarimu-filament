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
        try {
            $socialUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/app')->withErrors(['error' => 'Unable to authenticate with Google: ' . $e->getMessage()]);
        }

        // Proceed with the rest of the logic if no exception was thrown
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
                    'nomor_hp' => $socialUser->phone,
                    'password' => Hash::make('passwordGoogleDefault'),
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
