<html>

<head>
    <link rel="stylesheet" href="{{ url('css/register.css') }}">
    <link rel="stylesheet" href="{{ url('css/common.css') }}">
    <meta name ="viewport" content="width=device-width, initial-scale=1">

    <script src="{{ url('js/register.js') }}" defer></script>
</head>

<body>
        <main>
                    <div class="register-container">
                        <img src="{{ url('./img/sfondio-particella-di-tecnologia-astratta-realistica_23-2148431735.jpg') }}" class="sfondo" alt="">
                        <h1>Registrazione</h1>
                        <p id="msg"></p>
                        <form method='post'>
                            @csrf
                            <label>Username <input name="username" id='username' placeholder="Inserisci il tuo username" value='{{ old("username") }}'></label>
                            <label>Password <input type="password" name='password' placeholder="Inserisci la tua password" id='password' value='{{ old("password") }}'></label>
                            <label>Conferma Password <input type="password" name='conferma' placeholder="Conferma la password" id='conferma' value='{{ old("conferma") }}'></label>
                            <div class="submit-container">
                                <label>&nbsp; <input type="submit" value='Registrati' class="btn-register" id="register"></label>
                            </div>
                        </form>
                        <span>Hai già un account? </span><a href="{{ url('login') }}"><strong> Accedi</strong></a>
                    </div>
        </main>
</body>

</html>