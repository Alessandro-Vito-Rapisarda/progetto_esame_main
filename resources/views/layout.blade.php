<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="{{ url('css/home.css') }}">
    <link rel="stylesheet" href="{{ url('css/shopping.css') }}">
    <link rel="stylesheet" href="{{ url('css/homequery.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>


 @yield('scripts')
    <script src="{{ url('js/home.js') }}" defer></script>
    <script src="{{ url('js/shopping.js') }}" defer></script>

<body class=@yield('body-class', '')>

    <nav>
        <a href="{{ url('home') }}" class="nav-logo"><img src="{{ url('assets/logo.svg') }}" alt="Apple Logo"></a>
        <button class="hamburger" id="hamburger-btn" aria-label="Menu" aria-expanded="false">
            <span class="hamburger-icon">&#9776;</span>
        </button>
        <div class="nav-links" id="nav-links">
            <a href="{{ url('prodotti') }}">Store</a>
            <a href="{{ url('spotify') }}">Spotify</a>
            <a href="{{ url('fakestore') }}">FakeStore</a>

            <div class="hamburger-only" id="hamburger-extra-buttons">
                <form id="hamburger-search-form" action="{{ url('prodotti') }}" method="get">
                    <input type="text" name="nome" placeholder="Cerca prodotti..." class="hamburger-search-input">
                    <button type="submit" class="hamburger-btn search-btn">
                        <img src="{{ url('assets/search.svg') }}" alt="Cerca" class="hamburger-btn-icon" /> Cerca
                    </button>
                </form>
                <div class="hamburger-spacer"></div>
                <form method="get" action="{{ url('logout') }}">
                    <button type="submit" class="hamburger-btn logout-btn">
                        <img src="{{ url('assets/account.png') }}" alt="Logout" class="hamburger-btn-icon"> Logout
                    </button>
                </form>
            </div>
        </div>
        <div class="dropdown-account" id="account-dropdown-wrapper">
            <div class="account">
                <a href="#" id="account-btn"><img src="{{ url('assets/account.png') }}" alt="profilo"></a>
            </div>
            <div id="account-dropdown" class="account-dropdown">
                <form method="get" action="{{ url('logout') }}">
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
        <div class="search-dropdown-wrapper" id="search-btn-wrapper">
            <a href="#" id="search-btn"><img src="{{ url('assets/search.svg') }}" alt="lente"></a>
            <div id="search-dropdown" class="search-dropdown">
                <form id="search-form" action="{{ url('prodotti') }}" method="get">
                    <input type="text" name="nome" id="search-input" placeholder="Cerca prodotti..."
                        value="{{ request('nome') }}">
                        <div id = "result"></div>
                    <button id="searchBtn" type="submit">Cerca</button>
                </form>
            </div>
        </div>
        <a href="{{ url('/shopping') }}" id="shopping-btn"><img src="{{ url('assets/shopping.svg') }}"
                alt="shopping"></a>
        <span id="welcome-message">Benvenuto, {{$username ?? ''}}</span>
    </nav>

    <main>
        <div id="result">
            
        </div>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="footer-flex" id="footer-flex">
            <div class="footer-block-fakestore">
                <span class="fakestore-label">Continua ad acquistare su FakeStore</span>
                <a href="{{ url('fakestore') }}">
                    <img src="{{ url('assets/common/fakestore.png') }}" alt="FakeStore" class="fakestore-img">
                </a>
            </div>
            <div class="footer-block-right">
                <span class="spotify-label">Ascolta su <img src="{{ url('assets/common/spotify.jpg') }}" alt="Spotify"
                        class="spotify-track-text"></span>
                <div class="spotify-track-info">
                    <a href="{{ url('spotify') }}" class="spotify-track-link">
                        <img src="https://i.scdn.co/image/ab67616d0000b2738863bc11d2aa12b54f5aeb36"
                            alt="Copertina brano" class="spotify-track-img">
                        <span class="spotify-track-text">Blinding Lights<br>The Weeknd</span>
                    </a>
                </div>
            </div>
        </div>

        
        <button class="footer-hamburger" id="footer-hamburger" aria-label="Menu API">
            &#9776;
        </button>
        <div class="footer-api-menu" id="footer-api-menu">
            <a href="{{ url('spotify') }}" class="footer-api-link">
                <img src="{{ url('assets/common/spotify.jpg') }}" alt="Spotify"> Spotify
            </a>
            <div class="fakestore-info">
                <a href="{{ url('fakestore') }}" class="footer-api-link">
                    <img src="{{ url('assets/common/fakestore.png') }}" alt="FakeStore"> FakeStore
                </a>
            </div>
        </div>
        <div class="footer-center">
            <p>&copy; {{ date('Y') }} Tutti i diritti riservati.<br>
                <br>Powered By: Diego Favitta, 1000044715
            </p>
        </div>
    </footer>

   



</body>

</html>