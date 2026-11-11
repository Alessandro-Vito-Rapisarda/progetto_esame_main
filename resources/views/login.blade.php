<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="{{ url('css/login.css') }}">
    <link rel="stylesheet" href="{{ url('css/homequery.css') }}">
    <script src="{{ url('js/login.js') }}" defer></script>
</head>

<body>
    <main>
        <div class="login-container">
            <img src="{{ url('img/sfondio-particella-di-tecnologia-astratta-realistica_23-2148431735.jpg') }}"
                class="sfondo" alt="">
            <h1>Login</h1>
            @if(session('status'))
                <p class="success-msg status-msg">{{ session('status') }}</p>
            @endif
            <p id="msg" class="msg error-msg">{{ $errors->first() }}</p>
            <form id="login-form" method="post" action="{{ url('login') }}" novalidate>
                @csrf
                <label>Username <input name="username" id="username" maxlength="100" autocomplete="username"
                        placeholder="Inserisci il tuo username" value="{{ old('username') }}"></label>
                <label>Password <input type="password" name="password" id="password" maxlength="255"
                        autocomplete="current-password" placeholder="Inserisci la tua password"></label>
                <div class="submit-container">
                    <label>&nbsp; <input type="submit" value="Accedi" class="btn-login" id="submit"></label>
                </div>
            </form>

            <span>Non hai un account? </span><a href="{{ url('register') }}"><strong> Registrati</strong></a>
        </div>
    </main>
</body>

</html>
