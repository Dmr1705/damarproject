<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:anggota,admin'],
            
            // Validasi password khusus admin
            'admin_secret_code' => ['nullable', function ($attribute, $value, $fail) use ($request) {
                if ($request->role === 'admin') {
                    if (empty($value)) {
                        $fail('Password khusus admin wajib diisi.');
                    } elseif ($value !== 'admin123') { // <-- Ganti 'rahasia123' dengan password rahasia admin Anda
                        $fail('Password khusus admin salah.');
                    }
                }
            }],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Diarahkan ke halaman awal (home) setelah berhasil daftar
        return redirect(route('home'));
    }
}