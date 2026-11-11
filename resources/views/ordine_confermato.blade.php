@extends('layout')

@section('title', 'Ordine confermato')

@section('head')
    <link rel="stylesheet" href="{{ url('css/checkout.css') }}">
@endsection

@section('content')
    <div class="ordine-successo-msg">
        <h2 class="ordine-successo-titolo">Ordine #{{ $ordine->id }} effettuato con successo &#10004;</h2>
        <p class="ordine-successo-testo">Grazie per il tuo acquisto!</p>
        <p class="ordine-successo-testo">Spedizione a: {{ $ordine->indirizzo_spedizione }}</p>
        <ul class="ordine-righe">
            @foreach($ordine->ordineProdotti as $riga)
                <li>{{ $riga->prodotto->nome ?? 'Prodotto' }} x {{ $riga->quantita }} - {{ number_format($riga->prezzo_unitario, 2) }} €</li>
            @endforeach
        </ul>
        <p class="ordine-successo-testo"><strong>Totale: {{ number_format($ordine->totale, 2) }} €</strong></p>
        <p><a href="{{ url('home') }}" class="prodotto-back-link-btn">Torna alla home</a></p>
    </div>
@endsection
