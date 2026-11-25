@extends('layouts.app')

@section('title', 'Catálogo de Productos · DAS Panadería')
@section('page', 'catalogo')

@section('content')
<section class="dash-hero fade-in">
  <div>
    <p class="crumbs"><a href="/dashboard">Panel</a> / Catálogo</p>
    <h1>Explora nuestros productos</h1>
    <p>Agrega lo que te guste al carrito o guárdalo en tus favoritos.</p>
  </div>
</section>

<section class="dash-grid">
  @forelse($products ?? [] as $product)
    <article class="dcard span-4 fade-in">
      <h3>{{ $product->nombre }}</h3>
      <p>{{ $product->descripcion }}</p>
      <strong>${{ number_format($product->precio_venta, 0, ',', '.') }}</strong>
      <form action="{{ route('cart.add', $product) }}" method="POST" style="margin-top: 10px;">
        @csrf
        <button type="submit" class="btn btn-olive">Agregar al carrito</button>
      </form>
    </article>
  @empty
    <p>No hay productos disponibles por el momento.</p>
  @endforelse
</section>
@endsection
