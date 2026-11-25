<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Product;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('product')
            ->where('usuario_id', Auth::id())
            ->get();

        return view('functionality.favoritos', compact('favorites'));
    }

    public function toggle(Product $product)
    {
        $userId = Auth::id();
        $favorite = Favorite::where('usuario_id', $userId)
            ->where('producto_id', $product->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $status = 'removed';
        } else {
            Favorite::create([
                'usuario_id' => $userId,
                'producto_id' => $product->id,
            ]);
            $status = 'added';
        }

        return response()->json(['status' => $status]);
    }
}
