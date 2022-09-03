<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->getId())->first();
            if ($finduser) {
                // dd($user->getId());
                # code...
                Auth::login($finduser);
                return redirect()->intended('/home');
            } else {
                # code...
                $newuser = User::create([
                    'name' => $user->getName(),
                    'username' => $user->getEmail(),
                    'email' => $user->getEmail(),
                    'google_id' => $user->getId(),
                    'status' => 'Customer',
                    'password' => bcrypt('12345678')
                ]);
                Auth::login($newuser);
                return redirect()->intended('/home');
            }
        } catch (\Throwable $th) {
        }
    }
}
