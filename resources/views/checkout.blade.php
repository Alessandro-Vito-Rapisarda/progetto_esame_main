@extends('layout')

@section('head')
    <link rel="stylesheet" href="{{ url('css/checkout.css') }}">
@endsection

@section('scripts')
    <script src="{{ url('js/checkout.js') }}" defer></script>
@endsection
<script src="{{ url('js/home.js') }}" defer></script>

@section('content')
    <h2 class="checkout-title">Checkout</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div id="checkout-cart">
    <h4>Riepilogo carrello</h4>
    <ul>
        @if($cart->count() > 0)
            @foreach($cart as $prodotto)
                <li>
                    @if($prodotto->copertina)
                        <img src="{{ url($prodotto->copertina) }}" alt="{{ $prodotto->nome }}" class="checkout-thumb">
                    @endif
                    <strong>{{ $prodotto->nome }}</strong> x {{ $prodotto->pivot->quantita }} - {{ $prodotto->prezzo }} €
                </li>
            @endforeach
        @else
        
            <li>Carrello vuoto</li>
        @endif
    </ul>
</div>

    <form id="checkout-form" action="{{ url('checkout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Conferma ordine</button>
    </form>
@endsection