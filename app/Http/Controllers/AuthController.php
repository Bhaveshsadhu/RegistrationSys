<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ActivationMail;
//use App\Http\Controllers\Controller1;

//use Illuminate\Routing\Controller;

use App\Mail\UserLockedMail; 
//extends Controller
class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'activation_token' => Str::random(60),
        ]);

        // Send activation email
        Mail::to($user->email)->send(new ActivationMail($user));
        //Mail::to($user->email)->send(new ActivationMail($user));

        return redirect()->route('login')->with('message', 'Activation link has been sent to your email.');
    }

    public function activateAccount($token)
    {
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Invalid activation link.');
        }

        $user->update([
            'activated' => true,
            'activation_token' => null,
        ]);

        return redirect()->route('login')->with('message', 'Account activated. You can now log in.');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('welcome');
        } else {
            $user = User::where('email', $request->email)->first();

            if ($user && $user->login_attempts < 5) {
                $user->increment('login_attempts');
            } elseif ($user) {
                $user->update([
                    'login_attempts' => 0,
                    'locked_at' => now(),
                ]);

                // Send user-locked email
                Mail::to($user->email)->send(new UserLockedMail($user));
                //Mail::to($user->email)->send(new ActivationMail($user));
            }

            return redirect()->route('login')->with('error', 'Invalid email or password.');
        }
    }
}
