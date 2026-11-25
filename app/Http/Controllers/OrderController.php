<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('details.product')
            ->where('usuario_id', Auth::id())
            ->latest()
            ->get();

        return view('functionality.pedidos', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['details.product', 'store']);
        return view('functionality.pedidos-detalle', compact('order'));
    }
}
