<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CatalogController extends Controller
{
    public function index()
    {
        $products = Product::where('activo', true)->get();
        return view('presentation.catalogo', compact('products'));
    }

    public function show(Product $product)
    {
        return view('presentation.catalogo-detalle', compact('product'));
    }

    public function panelIndex()
    {
        $products = Product::paginate(15);
        return view('functionality.catalogo', compact('products'));
    }
}
