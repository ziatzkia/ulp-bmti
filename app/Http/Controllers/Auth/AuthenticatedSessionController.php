<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
   public function store(LoginRequest $request): RedirectResponse
{
    $credentials = $request->only('email', 'password');

    $user = User::where('email', $credentials['email'])->first();

    if (! $user) {
        throw ValidationException::withMessages([
            'email' => 'Akun belum terdaftar.',
        ]);
    }

    if (! Hash::check($credentials['password'], $user->password)) {
        throw ValidationException::withMessages([
            'password' => 'Kata sandi salah.',
        ]);
    }

    Auth::login($user, $request->boolean('remember'));
    $request->session()->regenerate();

    // Redirect sesuai role
    if ($user->role === 'humas') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'divisi') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'users') {
        return redirect()->route('user.dashboard');
    } else {
        Auth::logout();
        throw ValidationException::withMessages([
            'email' => 'Role pengguna tidak dikenali.',
        ]);
    }
}
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
