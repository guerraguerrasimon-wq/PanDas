@extends('layouts.app')

@section('title', 'Inicio · DAS Panadería')
@section('page', 'home')

@section('styles')
<style>
  .customer-home {
    padding: 28px 0 56px;
  }

  .home-topline {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 22px;
  }

  .delivery-address {
    display: grid;
    gap: 3px;
  }

  .delivery-address span,
  .section-kicker {
    color: var(--muted);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
  }

  .delivery-address strong {
    font-size: 20px;
  }

  .home-cart {
    display: grid;
    place-items: center;
    position: relative;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--dark);
    color: #fff;
    text-decoration: none;
  }

  .home-cart span {
    position: absolute;
    top: -4px;
    right: -4px;
    display: grid;
    place-items: center;
    min-width: 20px;
    height: 20px;
    padding: 0 5px;
    border-radius: 999px;
    background: var(--accent);
    color: #fff;
    font-size: 11px;
    font-weight: 800;
  }

  .home-search {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 10px 8px 18px;
    margin-bottom: 28px;
    background: #fff;
    border-radius: 999px;
    box-shadow: 0 10px 35px rgba(31, 35, 28, .07);
  }

  .home-search input {
    width: 100%;
    min-width: 0;
    padding: 12px 0;
    border: 0;
    outline: 0;
    background: transparent;
    color: var(--ink);
    font: inherit;
  }

  .home-search button {
    flex: 0 0 auto;
    width: 44px;
    height: 44px;
    border: 0;
    border-radius: 50%;
    background: var(--accent);
    color: #fff;
    font-size: 18px;
    cursor: pointer;
  }

  .promo-card {
    position: relative;
    display: flex;
    align-items: end;
    min-height: 260px;
    overflow: hidden;
    padding: clamp(24px, 5vw, 44px);
    margin-bottom: 34px;
    border-radius: 32px;
    background:
      linear-gradient(90deg, rgba(25, 29, 22, .82), rgba(25, 29, 22, .14)),
      linear-gradient(135deg, #8a3025, #d27c47 58%, #e8bd82);
    color: #fff;
  }

  .promo-copy {
    position: relative;
    z-index: 1;
    max-width: 520px;
  }

  .promo-copy .section-kicker {
    color: rgba(255,255,255,.76);
  }

  .promo-copy h1 {
    max-width: 500px;
    margin: 10px 0;
    font-size: clamp(36px, 7vw, 62px);
    line-height: .98;
    letter-spacing: -.045em;
  }

  .promo-copy p {
    max-width: 390px;
    color: rgba(255,255,255,.86);
  }

  .promo-copy .btn {
    display: inline-flex;
    margin-top: 10px;
    text-decoration: none;
  }

  .quick-section,
  .featured-section {
    margin-top: 34px;
  }

  .home-section-heading {
    display: flex;
    align-items: end;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 16px;
  }

  .home-section-heading h2 {
    margin: 4px 0 0;
    font-size: clamp(25px, 4vw, 34px);
    letter-spacing: -.035em;
  }

  .home-section-heading a {
    color: var(--olive);
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
  }

  .quick-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
  }

  .quick-card {
    min-height: 145px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 20px;
    border-radius: 26px;
    background: #fff;
    color: var(--ink);
    text-decoration: none;
    box-shadow: 0 8px 28px rgba(31, 35, 28, .05);
    transition: transform .2s, box-shadow .2s;
  }

  .quick-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 32px rgba(31, 35, 28, .1);
  }

  .quick-card:nth-child(2) {
    background: var(--sage);
  }

  .quick-card:nth-child(3) {
    background: var(--dark);
    color: #fff;
  }

  .quick-card span {
    font-size: 30px;
  }

  .quick-card strong {
    font-size: 19px;
  }

  .home-product-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
  }

  .home-product {
    overflow: hidden;
    padding: 10px;
    border-radius: 26px;
    background: #fff;
    box-shadow: 0 8px 28px rgba(31, 35, 28, .06);
  }

  .home-product-image {
    display: grid;
    place-items: center;
    aspect-ratio: 1.15;
    overflow: hidden;
    border-radius: 19px;
    background: var(--sage);
  }

  .home-product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .home-product-image .product-placeholder {
    font-size: 42px;
  }

  .home-product h3 {
    margin: 13px 5px 4px;
    font-size: 17px;
  }

  .home-product p {
    min-height: 38px;
    margin: 0 5px 12px;
    color: var(--muted);
    font-size: 13px;
    line-height: 1.45;
  }

  .home-product-foot {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    margin: 0 4px 4px;
  }

  .home-product-foot strong {
    color: var(--olive);
    font-size: 18px;
  }

  .home-product-foot form {
    margin: 0;
  }

  .home-product-foot button {
    width: 42px;
    height: 42px;
    border: 0;
    border-radius: 50%;
    background: var(--dark);
    color: white;
    font-size: 21px;
    cursor: pointer;
  }

  .home-empty {
    grid-column: 1 / -1;
    padding: 28px;
    border-radius: 24px;
    background: #fff;
    color: var(--muted);
    text-align: center;
  }

  @media (max-width: 850px) {
    .home-product-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }
  }

  @media (max-width: 600px) {
    .customer-home {
      padding-top: 20px;
    }

    .quick-grid {
      grid-template-columns: 1fr;
    }

    .quick-card {
      min-height: 112px;
    }

    .promo-card {
      min-height: 290px;
      border-radius: 26px;
    }

    .home-section-heading {
      align-items: start;
    }
  }

  @media (prefers-reduced-motion: reduce) {
    .quick-card {
      transition: none;
    }
  }
</style>
@endsection

@section('content')
<main class="wrap customer-home">
  <div class="home-topline">
    <div class="delivery-address">
      <span>Entregar en</span>
      <strong>{{ $recentAddress ?: 'Elige tu dirección' }}</strong>
    </div>

    <a class="home-cart" href="{{ route('cart.index') }}" aria-label="Abrir carrito">
      🛍
      @if(($cartCount ?? 0) > 0)
        <span>{{ $cartCount }}</span>
      @endif
    </a>
  </div>

  <form class="home-search" action="{{ route('catalog.index') }}" method="GET" role="search">
    <span aria-hidden="true">⌕</span>
    <input
      type="search"
      name="q"
      value="{{ request('q') }}"
      placeholder="¿Qué se te antoja hoy?"
      aria-label="Buscar productos"
    >
    <button type="submit" aria-label="Buscar">→</button>
  </form>

  <section class="promo-card" aria-label="Promoción destacada">
    <div class="promo-copy">
      <span class="section-kicker">Recién horneado para ti</span>
      <h1>Un buen día empieza con buen pan.</h1>
      <p>Descubre tus favoritos de DAS y pide algo delicioso para compartir.</p>
      <a class="btn btn-white sentence" href="{{ route('catalog.index') }}">Explorar catálogo</a>
    </div>
  </section>

  <section class="quick-section" aria-labelledby="quick-title">
    <div class="home-section-heading">
      <div>
        <span class="section-kicker">Elige tu antojo</span>
        <h2 id="quick-title">¿Qué se te antoja?</h2>
      </div>
    </div>

    <div class="quick-grid">
      <a class="quick-card" href="{{ route('catalog.index', ['categoria' => 'desayuno-rapido']) }}">
        <span aria-hidden="true">☕</span>
        <strong>Desayuno rápido</strong>
      </a>
      <a class="quick-card" href="{{ route('catalog.index', ['categoria' => 'desayunos-virales']) }}">
        <span aria-hidden="true">✨</span>
        <strong>Desayunos virales</strong>
      </a>
      <a class="quick-card" href="{{ route('catalog.index', ['categoria' => 'crazy-deals']) }}">
        <span aria-hidden="true">🔥</span>
        <strong>Crazy deals</strong>
      </a>
    </div>
  </section>

  <section class="featured-section" aria-labelledby="featured-title">
    <div class="home-section-heading">
      <div>
        <span class="section-kicker">Hecho en DAS</span>
        <h2 id="featured-title">Favoritos de la casa</h2>
      </div>
      <a href="{{ route('catalog.index') }}">Ver catálogo →</a>
    </div>

    <div class="home-product-grid">
      @forelse($featuredProducts as $product)
        <article class="home-product">
          <div class="home-product-image">
            @if($product->imagen_url)
              <img src="{{ $product->imagen_url }}" alt="{{ $product->nombre }}" loading="lazy">
            @else
              <span class="product-placeholder" aria-hidden="true">🥐</span>
            @endif
          </div>

          <h3>{{ $product->nombre }}</h3>
          <p>{{ $product->descripcion ?: 'Una delicia recién preparada en DAS.' }}</p>

          <div class="home-product-foot">
            <strong>${{ number_format($product->precio_venta, 0, ',', '.') }}</strong>
            <form action="{{ route('cart.add', $product) }}" method="POST">
              @csrf
              <button type="submit" aria-label="Agregar {{ $product->nombre }} al carrito">+</button>
            </form>
          </div>
        </article>
      @empty
        <div class="home-empty">
          Aún no hay productos destacados disponibles. Vuelve pronto para descubrir lo recién horneado.
        </div>
      @endforelse
    </div>
  </section>
</main>
@endsection