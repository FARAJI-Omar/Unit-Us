<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WelcomeController extends Controller
{
    public function showWelcomeForm(string $slug)
    {
        return view('welcome', ['slug' => $slug]);
    }

    public function setPassword(Request $request, string $slug)
    {
        $request->validate([
            'email' => 'required|email',
            'temp_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->temp_password, $user->password)) {
            return back()->withErrors(['error' => 'Invalid credentials']);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return view('success', ['slug' => $slug]);
    }
}
