<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $data = $request->only(['email', 'password']);
        $user = User::where(['email' => $data['email']])->first();
        if (is_null($user)) return redirect()->back()->with('error', 'Incorrect Credentials');
        $authAttempt = Auth::attempt($data);
        if (!$authAttempt) return redirect()->back()->with('error', 'Incorrect Credentials');
        return redirect()->intended('/');
    }
}
