<html>

<head>
    <link rel="stylesheet" href="{{ url('css/login.css') }}">
    <link rel="stylesheet" href="{{ url('css/homequery.css') }}">
    <meta name ="viewport" content="width=device-width, initial-scale=1">
    <script src="{{ url('js/login.js') }}" defer></script>
</head>

<body>
    <main>
        <div class="login-container">
            <img src="{{ url('./img/sfondio-particella-di-tecnologia-astratta-realistica_23-2148431735.jpg') }}"
                class="sfondo" alt="">
            <h1>Login</h1>
            <p id="msg" class="msg"></p>
            <form id="login-form" method='post' action="{{ url('login') }}">
                @csrf
                <label>Username <input name="username" id='username' placeholder="Inserisci il tuo username"
                        value='{{ old("username") }}'></label>
                <label>Password <input type="password" name='password' placeholder="Inserisci la tua password"
                        id='password'></label>
                <div class="submit-container">
                    <label>&nbsp; <input type="submit" value='Accedi' class="btn-login" id="submit"></label>
                </div>
            </form>

            <span>Non hai un account? </span><a href="{{ url('register') }}"><strong> Registrati</strong></a>
        </div>
    </main>
</body>

</html>