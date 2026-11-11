@extends('layout')

@section('title', 'Carrello')

@section('head')
    <link rel="stylesheet" href="{{ url('css/shopping.css') }}">
@endsection

@section('scripts')
    <script src="{{ url('js/shopping.js') }}" defer></script>
@endsection

@section('content')
    @include('partials.flash')

    @if($prodotti->isEmpty())
        <div id="shopping-items">
            <div class="empty-cart-message">
                <span>&#128722;</span>
                <h3>La shopping bag è vuota.</h3>
                <p>Che ne dici di guardare qualcosa nello store?</p>
                <a href="{{ url('prodotti') }}" class="empty-cart-btn">Vai allo store</a>
            </div>
        </div>
    @else
        <h2 class="shopping-title">Shopping Bag</h2>

        <div class="checkout-summary-custom" id="cart-summary">
            <h3>Riepilogo ordine</h3>
            <div class="checkout-summary-list">
                @foreach($prodotti as $prodotto)
                    <div class="checkout-summary-item">
                        <div class="checkout-summary-item-img">
                            @if($prodotto->foto)
                                <img src="{{ url($prodotto->foto) }}" alt="{{ $prodotto->nome }}">
                            @endif
                        </div>
                        <div class="checkout-summary-item-info">
                            <div class="checkout-summary-item-name">{{ $prodotto->nome }}</div>
                            <div class="checkout-summary-item-qty">
                                <form action="{{ url('shopping/update') }}" method="post" class="cart-qty-form">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="prodotto_id" value="{{ $prodotto->id }}">
                                    <label>Quantità:
                                        <input type="number" name="quantita" value="{{ $prodotto->pivot->quantita }}"
                                            min="1" max="99" step="1" class="cart-qty-input">
                                    </label>
                                    <button type="submit" class="cart-update-btn">Aggiorna</button>
                                </form>

                                <form action="{{ url('shopping/remove') }}" method="post" class="cart-remove-form">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="prodotto_id" value="{{ $prodotto->id }}">
                                    <button type="submit" class="cart-remove-btn" title="Rimuovi dal carrello">&times;</button>
                                </form>
                            </div>
                            <div class="checkout-summary-item-price">Prezzo: <b>{{ number_format($prodotto->prezzo, 2) }} €</b></div>
                            <div class="checkout-summary-item-sub">Subtotale: <b>{{ number_format($prodotto->prezzo * $prodotto->pivot->quantita, 2) }} €</b></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="checkout-summary-total">
                <span>Totale:</span>
                <span class="checkout-summary-total-value">{{ number_format($totale, 2) }} €</span>
            </div>
            <div class="checkout-summary-divider">
                <a href="{{ url('checkout') }}" class="checkout-mobile-btn">Procedi al Checkout</a>
            </div>
        </div>
    @endif
@endsection
