// Validazione lato browser del login (la stessa viene rifatta lato server in LoginRequest)
(function () {
    const form = document.querySelector('#login-form');
    const msg = document.querySelector('#msg');
    const username = document.querySelector('#username');
    const password = document.querySelector('#password');

    if (!form) {
        return;
    }

    function validate() {
        if (username.value.trim() === '') {
            return 'Inserisci lo username.';
        }
        if (username.value.length > 100) {
            return 'Username troppo lungo.';
        }
        if (password.value === '') {
            return 'Inserisci la password.';
        }
        if (password.value.length > 255) {
            return 'Password troppo lunga.';
        }
        return '';
    }

    function onInput() {
        msg.textContent = '';
    }

    function onSubmit(e) {
        const error = validate();
        if (error !== '') {
            e.preventDefault();
            msg.textContent = error;
        }
    }

    username.addEventListener('input', onInput);
    password.addEventListener('input', onInput);
    form.addEventListener('submit', onSubmit);
})();
