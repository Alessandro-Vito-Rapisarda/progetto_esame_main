@extends('layout')

@section('head')
    <link rel="stylesheet" href="{{ url('css/home.css') }}">
    <link rel="stylesheet" href="{{ url('css/homequery.css') }}">
    <meta name ="viewport" content="width=device-width, initial-scale=1">

@endsection

@section('scripts')
    <script src ='{{ url("js/home.js") }}'defer></script>
@endsection

@section('body-class', 'home-page')

@section('content')
   <div class='hero'>
    <img src="{{ url('assets/common/sfondo apple.png') }}" alt="sfondo" class="wallpaper">
        <div class="hero-content">
            <div class="bubble-wrapper">
                <div class='hero-title'>
                    <p>Compra Mac o iPad per l'università</p>
                </div>
            </div>
            <div class='sticker'>
                <img class="img1" src="{{ url('assets/common/hero_sticker_mba__b0ht7774wpaq_largetall.png') }}" alt="MacBook Air">
                <img class='img2' src="{{ url('assets/common/hero_sticker_ipadair__bk6ffplndvte_largetall.png') }}" alt="ipad">
            </div>
            <div class='hero-overlay'>
                <div class="bubble-wrapper edu-container">
                    <p class="edu">con i prezzi Education</p>
                </div>
            </div>
            <div class='hero-background'>
                <img class="genmoij" src="{{ url('assets/common/genmoij.png') }}" alt="genmoij">
                <div class="bubble-wrapper">
                    <p>Scegli un paio di Airpods o un accesorio idoneo <span id='numero'></span> </p>
                </div>
            </div>
            <div class='hero-bottom'>
                <div class="button">
                    <a href="{{ url('prodotti') }}" class="btn">Acquista</a>
                </div>
            </div>
        </div>
    </div>
    <div class='hero-iphone'>
        <div class='hero-iphone-title'>
            <p>iPhone</p>
        </div>
        <div class='hero-iphone-description'>
            <p>Ti presentiamo la famiglia iPhone 17.</p>
        </div>
    <img src="{{ asset('img/iphone17sfondo.jpg') }}" alt="iphone17sfondo">
        <div class='hero-iphone-button'>
            <div class="button">
                <a href="{{ url('prodotti') }}" class="btn">Scopri di più</a>
            </div>
        </div>
        <div class='hero-iphone-subdescription'>
            <p>Progettati per Apple Intelligence</p>
        </div>
    </div>
    <div class="hero-macbook">
        <h2>Scopri i nuovi Macbook</h2>
    <img src="{{ url(path: 'assets/common/promo_macbook_air_avail__e8ksaudoisey_large.jpg') }}" alt="evento">
    <div class='hero-macbook-subdescription'>
            <p>Progettati per Apple Intelligence</p>
        </div>
        <div class="hero-macbook-button">
            <div class="button">
               <a href="{{ url('prodotti') }}" class="btn">Scopri di più</a>
            </div>
        </div>
    </div>
    <div class="homepage">
        
    </div>

@endsection




