@extends('layouts.app')

@section('title', 'Carrito de Compras · DAS Panadería')
@section('page', 'carrito')

@section('content')
<section class="dash-hero fade-in">
  <div>
    <p class="crumbs"><a href="/dashboard">Panel</a> / Carrito</p>
    <h1>Tu Carrito de Compras</h1>
    <p>Revisa tus delicias seleccionadas antes de ordenar.</p>
  </div>
</section>

<section class="dash-grid">
  <div class="span-8">
    @forelse($cartItems ?? [] as $item)
      <article class="dcard fade-in" style="margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center;">
        <div>
          <h4>{{ $item->product?->nombre ?? 'Producto' }}</h4>
          <p>Cantidad: {{ $item->cantidad }} · ${{ number_format($item->product?->precio_venta ?? 0, 0, ',', '.') }} c/u</p>
        </div>
        <form action="{{ route('cart.remove', $item) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-soft">Eliminar</button>
        </form>
      </article>
    @empty
      <div class="dcard">
        <p>Tu carrito está vacío.</p>
        <a href="/catalogo" class="btn btn-olive" style="margin-top: 10px;">Ver catálogo</a>
      </div>
    @endforelse
  </div>

  <div class="span-4">
    <article class="dcard olive fade-in">
      <span class="eyebrow">Resumen del pedido</span>
      <h2 style="margin: 10px 0;">Total: ${{ number_format($total ?? 0, 0, ',', '.') }}</h2>
      <a href="/pedidos/checkout" class="btn btn-white sentence" style="width: 100%; text-align: center;">Continuar compra</a>
    </article>
  </div>
</section>
@endsection
