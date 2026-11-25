<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\LocationSuggestion;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::where('activo', true)->get();
        return view('presentation.ubicaciones', compact('stores'));
    }

    public function suggestLocation(Request $request)
    {
        $validated = $request->validate([
            'ciudad' => 'required|string|max:100',
            'zona_barrio' => 'required|string|max:150',
            'comentario' => 'nullable|string|max:500',
        ]);

        LocationSuggestion::create($validated);

        return back()->with('success', '¡Gracias por sugerirnos una ubicación!');
    }
}
