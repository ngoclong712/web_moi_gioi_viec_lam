<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function callback($provider)
    {
        $data = Socialite::driver($provider)->user();

        $user = User::firstOrCreate([
            'email' => $data->getEmail()
        ], [
           'name' => $data->getName(),
            'avatar' => $data->getAvatar(),
        ]);

        Auth::login($user);

        return redirect()->route('register');
    }

    public function registering(Request $request)
    {
        $password = Hash::make($request->get('password'));
        if(Auth::check()){
            User::query()->where('id', auth()->user()->id)
                ->update([
                    'password' => $password,
                ]);
        }
        else {
            $user = User::query()->create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => $password,
            ]);

            Auth::login($user);
        }
    }
}
