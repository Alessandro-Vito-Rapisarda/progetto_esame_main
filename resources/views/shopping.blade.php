@extends('layout')
<link rel="stylesheet" href="{{ url('css/shopping.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=shopping_cart" />
@section('content')
    @if(count($cart) === 0)
        <div id = 'shopping-items' >
        </div>
    @else
        <h2 class="shopping-title">Shopping Bag</h2>
        <div id="shopping-items"></div>

        <div id="subTotale"></div>
        <div class="checkout-btn-wrapper">
        <a href="{{ url('checkout') }}" class="btn btn-primary cart-checkout-btn">Checkout</a>
    </div>


    <div class="checkout-summary-custom" id="checkout-mobile">
        <h3>Riepilogo ordine</h3>
        <div class="checkout-summary-list">
            @foreach($cart as $prodotto)
                <div class="checkout-summary-item">
                    <div class="checkout-summary-item-img">
                        @if($prodotto['foto'])
                            <img src="{{ url($prodotto['foto']) }}" alt="{{ $prodotto['nome'] }}">
                        @endif
                    </div>
                    <div class="checkout-summary-item-info">
                        <div class="checkout-summary-item-name">{{ $prodotto['nome'] }}</div>
                        <div class="checkout-summary-item-qty">
                            <form action="{{ url('shopping/update') }}" method="POST" class="cart-qty-form">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="prodotto_id" value="{{ $prodotto['id'] }}">
                                Quantità:
                                <input type="number" name="quantita" value="{{ $prodotto['quantita'] }}" min="1" max="99" class="cart-qty-input"  >
                            </form>

                            <form action="{{ url('shopping/remove') }}" method="POST" class="cart-remove-form" >
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="prodotto_id" value="{{ $prodotto['id'] }}">
                        <button type="submit" class="cart-remove-btn" title="Rimuovi dal carrello">&times;</button>
                    </form>
                        </div>
                        <div class="checkout-summary-item-price">Prezzo: <b>{{ number_format($prodotto['prezzo'], 2) }} €</b></div>
                        <div class="checkout-summary-item-sub">Subtotale: <b>{{ number_format($prodotto['subtotale'], 2) }} €</b></div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="checkout-summary-total">
            <span>Totale:</span>
            <span class="checkout-summary-total-value">{{ number_format($totale, 2) }} €</span>
        </div>
        <div class="checkout-summary-divider">
        <a href="{{ url('checkout') }}" class="btn btn-primary checkout-mobile-btn">Checkout</a>
        </div>
    </div>
       @endif
@endsection
