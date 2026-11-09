@extends('layout')

@section('head')
    <title>Scheda Prodotto</title>
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
        <div id="dettaglio-prodotto" data-id="{{ $prodotto->id }}"></div>
    </div>
    <div class="prodotto-back-link-wrapper">
        <a href="{{ url($backUrl) }}" class="prodotto-back-link-btn"> Torna alla lista prodotti</a>
    </div>
@endsection
