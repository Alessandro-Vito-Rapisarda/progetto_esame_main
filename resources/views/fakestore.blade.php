<script type="module" src="js/fakestore.js" defer></script>
@extends('layout')

@section('head')
    <title>FakeStore</title>
    <link rel="stylesheet" href="{{ url('css/fakestore.css') }}">
@endsection

@section('content')
    <div class="fakestore-title">
        <h1>FakeStore - Prodotti</h1>
    </div>
    </div>

    <div id="fakestore-products" class="fakestore-products"></div>
    <div id="fakestore-cart" class="hidden"></div>
@endsection