<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        return view('presentation.contacto');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:120',
            'correo' => 'required|email|max:150',
            'telefono' => 'nullable|string|max:30',
            'asunto' => 'required|string|max:150',
            'mensaje' => 'required|string',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Tu mensaje ha sido enviado correctamente.');
    }
}
