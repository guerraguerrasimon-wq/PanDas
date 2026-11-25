<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('functionality.perfil', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nombres' => 'required|string|max:80',
            'apellidos' => 'required|string|max:80',
            'correo' => 'required|email|max:120|unique:usuarios,correo,' . $user?->id,
            'telefono' => 'nullable|string|max:30',
        ]);

        $user?->update($validated);

        return back()->with('success', 'Perfil actualizado exitosamente.');
    }
}
