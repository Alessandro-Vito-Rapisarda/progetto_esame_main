@extends('layout')

@section('title', 'Lista Prodotti')

@section('head')
    <link rel="stylesheet" href="{{ url('css/prodotti.css') }}">
@endsection

@section('scripts')
    <script src="{{ url('js/prodotti.js') }}" defer></script>
@endsection

@section('content')
    <div class="prodotti-hero">
        <div class="prodotti-title">Store</div>
        <div class="prodotti-desc">
            @if($ricerca)
                Risultati per &laquo;{{ $ricerca }}&raquo;
            @else
                Scopri tutti i prodotti disponibili nello store.
            @endif
        </div>
    </div>

    @include('partials.flash')

    <div id="prodotti-container" class="prodotti-list">
        @forelse($prodotti as $prodotto)
            <div class="prodotto-card">
                <a href="{{ url('prodotto/' . $prodotto->id) }}" class="dettaglio-link">
                    @if($prodotto->foto)
                        <img src="{{ url($prodotto->foto) }}" alt="{{ $prodotto->nome }}" class="prodotto-img">
                    @endif
                    <div class="prodotto-nome">{{ $prodotto->nome }}</div>
                    <div class="prodotto-prezzo">{{ number_format($prodotto->prezzo, 2) }} €</div>
                    <div class="prodotto-desc">{{ $prodotto->descrizione }}</div>
                </a>
                @include('partials.add-to-cart', ['prodotto' => $prodotto])
            </div>
        @empty
            <p class="prodotti-vuoti">Nessun prodotto trovato.</p>
        @endforelse
    </div>
@endsection
