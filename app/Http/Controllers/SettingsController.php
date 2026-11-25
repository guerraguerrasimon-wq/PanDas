<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('functionality.configuracion', compact('user'));
    }

    public function update(Request $request)
    {
        return back()->with('success', 'Preferencias actualizadas correctamente.');
    }
}
