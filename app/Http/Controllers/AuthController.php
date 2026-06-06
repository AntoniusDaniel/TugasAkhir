<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return Auth::user()->is_admin
                ? redirect()->route('admin.dashboard')
                : redirect()->route('registrations.create');
        }

        return view('auth.login');
    }

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return Auth::user()->is_admin
                ? redirect()->route('admin.dashboard')
                : redirect()->route('registrations.create');
        }

        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'is_admin' => false,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('registrations.create')
            ->with('success', 'Akun pendaftar berhasil dibuat. Silakan lanjutkan mengisi form pendaftaran.');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return Auth::user()->is_admin
                ? redirect()->intended(route('admin.dashboard'))
                : redirect()->intended(route('registrations.create'));
        }

        return back()
            ->withErrors(['email' => 'Email atau password tidak sesuai.'])
            ->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
