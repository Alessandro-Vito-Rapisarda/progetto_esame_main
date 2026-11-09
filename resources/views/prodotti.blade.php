@extends('layout')
@section('scripts')
    <script src="{{ url('js/prodotti.js') }}" defer></script>
@endsection

@section('head')
    <title>Lista Prodotti</title>
    <link rel="stylesheet" href="{{ url('css/prodotti.css') }}">
@endsection



@section('content')
    <div class="prodotti-hero">
        <div class="prodotti-title">Store</div>
        <div class="prodotti-desc">Scopri tutti i prodotti disponibili nello store.</div>
    </div>
<div id="prodotti-container" class="prodotti-list">
    
</div>          
@endsection




