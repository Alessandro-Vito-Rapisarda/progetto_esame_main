@extends('layout')

@section('head')
    <title>Checkout</title>
    <link rel="stylesheet" href="{{ url('css/checkout.css') }}">
@endsection

@section('scripts')
    <script src="{{ url('js/home.js') }}" defer></script>
    <script src="{{ url('js/checkout.js') }}" defer></script>
@endsection

@section('content')
    <h2 class="checkout-title">Checkout</h2>

    @if(session('error'))
        <div class="custom-alert alert-error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="custom-alert alert-success">{{ session('success') }}</div>
    @endif

    <div id="checkout-cart">
        <h4>Riepilogo carrello</h4>
        <ul>
            @if(isset($cart) && $cart->count() > 0)
                @foreach($cart as $prodotto)
                    <li>
                        @if(!empty($prodotto->immagine_url))
                            <img src="{{ url($prodotto->immagine_url) }}" alt="{{ $prodotto->nome }}" class="checkout-thumb">
                        @elseif($prodotto->immagini && $prodotto->immagini->count() > 0)
                            <img src="{{ url($prodotto->immagini->first()->url) }}" alt="{{ $prodotto->nome }}" class="checkout-thumb">
                        @endif
                        <strong>{{ $prodotto->nome }}</strong> x {{ $prodotto->pivot->quantita }} - {{ number_format($prodotto->prezzo, 2) }} €
                    </li>
                @endforeach
            @else
                <li>Carrello vuoto</li>
            @endif
        </ul>
    </div>

    <form id="checkout-form" action="{{ url('checkout') }}" method="POST">
        @csrf
        <button type="submit" class="checkout-confirm-btn">Conferma ordine</button>
    </form>
@endsection
