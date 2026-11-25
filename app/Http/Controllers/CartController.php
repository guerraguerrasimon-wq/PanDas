<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('usuario_id', Auth::id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return ($item->product?->precio ?? 0) * $item->cantidad;
        });

        return view('functionality.carrito', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $quantity = $request->input('cantidad', 1);
        $userId = Auth::id();

        $cart = Cart::firstOrNew([
            'usuario_id' => $userId,
            'producto_id' => $product->id,
        ]);

        $cart->cantidad = ($cart->exists ? $cart->cantidad : 0) + $quantity;
        $cart->save();

        return back()->with('success', 'Producto agregado al carrito.');
    }

    public function remove(Cart $cart)
    {
        $cart->delete();
        return back()->with('success', 'Producto eliminado del carrito.');
    }
}
