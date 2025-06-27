<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    public function create() { return view('auth.login'); }

    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required|string']);
        $response = Http::post('https://jwt-auth-eight-neon.vercel.app/login', ['email' => $request->email, 'password' => $request->password]);
        if (!$response->successful() || !$response->json('refreshToken')) {
            return back()->withErrors(['email' => 'Email atau Password yang Anda berikan salah.'])->onlyInput('email');
        }
        $request->session()->put('refreshToken', $response->json('refreshToken'));
        $user = User::firstOrCreate(['email' => $request->email], ['name' => explode('@', $request->email)[0], 'password' => bcrypt(str()->random(10))]);
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request)
    {
        $refreshToken = $request->session()->get('refreshToken');
        if ($refreshToken) { Http::withToken($refreshToken)->post('https://jwt-auth-eight-neon.vercel.app/logout'); }
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
