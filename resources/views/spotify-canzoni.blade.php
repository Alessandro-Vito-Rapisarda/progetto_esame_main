@extends('layout')

@section('title', 'Spotify - Ricerca Canzoni')

@section('head')
    <link rel="stylesheet" href="{{ url('css/spotify.css') }}">
@endsection

@section('scripts')
    <script type="module" src="{{ url('js/spotifySong.js') }}"></script>
@endsection

@section('content')
    <div class="spotify-hero">
        <img src="{{ url('assets/common/spotify.jpg') }}" alt="Spotify" class="spotify-hero-logo">
        <h1 class="spotify-title">Spotify Music</h1>
        <p class="spotify-desc">Cerca canzoni da Spotify!</p>
    </div>
    <div class="spotify-search-flex">
        <div id="song-container"></div>
    </div>
    <div class="spotify-switch-search">
        <a href="{{ url('spotify') }}" class="spotify-switch-btn">Cerca per album</a>
    </div>
@endsection
