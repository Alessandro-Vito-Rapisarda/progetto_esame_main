@extends('layout')
<link rel="stylesheet" href="{{ url('css/checkout.css') }}">
@section('content')
    <div class="ordine-successo-msg" data-redirect="{{ url('home') }}">
    <h2 class="ordine-successo-titolo">Ordine effettuato con successo &#10004;</h2>
    <p class="ordine-successo-testo">Grazie per il tuo acquisto! Riceverai una email di conferma a breve.</p>
    </div>

@endsection
