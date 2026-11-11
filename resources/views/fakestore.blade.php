@extends('layout')

@section('title', 'FakeStore')

@section('head')
    <link rel="stylesheet" href="{{ url('css/fakestore.css') }}">
@endsection

@section('scripts')
    <script src="{{ url('js/fakestore.js') }}" defer></script>
@endsection

@section('content')
    <div class="fakestore-title">
        <h1>FakeStore - Prodotti</h1>
    </div>

    <div id="fakestore-products" class="fakestore-products"></div>
    <div id="fakestore-cart" class="hidden"></div>
@endsection
