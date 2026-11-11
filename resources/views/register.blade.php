<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrazione</title>
    <link rel="stylesheet" href="{{ url('css/register.css') }}">
    <link rel="stylesheet" href="{{ url('css/common.css') }}">
    <script src="{{ url('js/register.js') }}" defer></script>
</head>

<body>
    <main>
        <div class="register-container">
            <img src="{{ url('img/sfondio-particella-di-tecnologia-astratta-realistica_23-2148431735.jpg') }}"
                class="sfondo" alt="">
            <h1>Registrazione</h1>
            <p id="msg" class="msg">{{ $errors->first() }}</p>
            <form id="register-form" method="post" action="{{ url('register') }}" novalidate>
                @csrf
                <label>Username <input name="username" id="username" maxlength="30" autocomplete="username"
                        placeholder="Inserisci il tuo username" value="{{ old('username') }}"></label>
                <label>Password <input type="password" name="password" id="password" maxlength="72"
                        autocomplete="new-password" placeholder="Inserisci la tua password"></label>
                <label>Conferma Password <input type="password" name="conferma" id="conferma" maxlength="72"
                        autocomplete="new-password" placeholder="Conferma la password"></label>
                <div class="submit-container">
                    <label>&nbsp; <input type="submit" value="Registrati" class="btn-register" id="register"></label>
                </div>
            </form>
            <span>Hai già un account? </span><a href="{{ url('login') }}"><strong> Accedi</strong></a>
        </div>
    </main>
</body>

</html>
