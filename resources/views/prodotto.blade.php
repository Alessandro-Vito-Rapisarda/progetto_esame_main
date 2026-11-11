@extends('layout')

@section('title', $prodotto->nome)

@section('head')
    <link rel="stylesheet" href="{{ url('css/prodotti.css') }}">
@endsection

@section('scripts')
    <script src="{{ url('js/prodotti.js') }}" defer></script>
@endsection

@section('content')
    <div class="prodotto-detail-wrapper">
        <div class="prodotto-hero">
            <h1 class="prodotto-title">Scheda prodotto</h1>
        </div>

        @include('partials.flash')

        <div id="dettaglio-prodotto">
            <div class="prodotto-card prodotto-card-center">
                @if($prodotto->foto)
                    <img src="{{ url($prodotto->foto) }}" alt="{{ $prodotto->nome }}" class="prodotto-img">
                @endif
                <div class="prodotto-nome prodotto-nome-big">{{ $prodotto->nome }}</div>
                <div class="prodotto-prezzo prodotto-prezzo-big">{{ number_format($prodotto->prezzo, 2) }} €</div>
                <div class="prodotto-desc">{{ $prodotto->descrizione }}</div>
                @include('partials.add-to-cart', ['prodotto' => $prodotto])
            </div>
        </div>
    </div>
    <div class="prodotto-back-link-wrapper">
        <a href="{{ url('prodotti') }}" class="prodotto-back-link-btn">Torna alla lista prodotti</a>
    </div>
@endsection
