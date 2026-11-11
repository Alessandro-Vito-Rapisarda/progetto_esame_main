@extends('layout')

@section('title', 'Checkout')

@section('head')
    <link rel="stylesheet" href="{{ url('css/checkout.css') }}">
@endsection

@section('scripts')
    <script src="{{ url('js/checkout.js') }}" defer></script>
@endsection

@section('content')
    <h2 class="checkout-title">Checkout</h2>

    @if($errors->any())
        <div class="custom-alert alert-error" id="checkout-error">{{ $errors->first() }}</div>
    @else
        <div class="custom-alert alert-error hidden" id="checkout-error"></div>
    @endif

    <div id="checkout-cart">
        <h4>Riepilogo carrello</h4>
        <ul>
            @foreach($prodotti as $prodotto)
                <li>
                    @if($prodotto->foto)
                        <img src="{{ url($prodotto->foto) }}" alt="{{ $prodotto->nome }}" class="checkout-thumb">
                    @endif
                    <span><strong>{{ $prodotto->nome }}</strong> x {{ $prodotto->pivot->quantita }} - {{ number_format($prodotto->prezzo, 2) }} €</span>
                </li>
            @endforeach
        </ul>
        <p class="checkout-total"><strong>Totale: {{ number_format($totale, 2) }} €</strong></p>
    </div>

    <form id="checkout-form" action="{{ url('checkout') }}" method="post" novalidate>
        @csrf
        <label for="indirizzo_spedizione" class="checkout-label">Indirizzo di spedizione</label>
        <input type="text" name="indirizzo_spedizione" id="indirizzo_spedizione" maxlength="255"
            placeholder="Via, numero civico, città" value="{{ old('indirizzo_spedizione') }}" class="checkout-input">
        <button type="submit" class="checkout-confirm-btn">Conferma ordine</button>
    </form>
@endsection
