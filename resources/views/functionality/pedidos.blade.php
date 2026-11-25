@extends('layouts.app')

@section('title', 'Mis Pedidos · DAS Panadería')
@section('page', 'pedidos')

@section('content')
<section class="dash-hero fade-in">
  <div>
    <p class="crumbs"><a href="/dashboard">Panel</a> / Pedidos</p>
    <h1>Historial de Pedidos</h1>
    <p>Consulta el estado y seguimiento de tus pedidos en DAS.</p>
  </div>
</section>

<section class="dash-grid">
  <div class="span-12">
    @forelse($orders ?? [] as $order)
      <article class="dcard fade-in" style="margin-bottom: 15px;">
        <div style="display: flex; justify-content: space-between;">
          <strong>Pedido #{{ $order->codigo_orden }}</strong>
          <span class="badge">{{ $order->estado }}</span>
        </div>
        <p>Total: ${{ number_format($order->total, 0, ',', '.') }} · Fecha: {{ $order->created_at?->format('d/m/Y H:i') }}</p>
        <p>Método de entrega: {{ $order->tipo_entrega }}</p>
      </article>
    @empty
      <div class="dcard">
        <p>Aún no has realizado pedidos.</p>
        <a href="/catalogo" class="btn btn-olive" style="margin-top: 10px;">Hacer mi primer pedido</a>
      </div>
    @endforelse
  </div>
</section>
@endsection
