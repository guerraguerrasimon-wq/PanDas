<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nombre_usuario' => ['required', 'string', 'max:50', 'unique:usuarios'],
            'nombres' => ['required', 'string', 'max:80'],
            'apellidos' => ['required', 'string', 'max:80'],
            'correo' => ['required', 'string', 'email', 'max:120', 'unique:usuarios'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'nombre_usuario' => $validated['nombre_usuario'],
            'nombres' => $validated['nombres'],
            'apellidos' => $validated['apellidos'],
            'correo' => $validated['correo'],
            'password_hash' => Hash::make($validated['password']),
            'rol_id' => 2, // Default client role
            'activo' => 1,
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
