// Validazione lato browser della registrazione (stesse regole di RegisterRequest lato server)
(function () {
    const form = document.querySelector('#register-form');
    const msg = document.querySelector('#msg');
    const usernameInput = document.querySelector('#username');
    const passwordInput = document.querySelector('#password');
    const confermaInput = document.querySelector('#conferma');

    if (!form) {
        return;
    }

    function validate() {
        const username = usernameInput.value.trim();
        const password = passwordInput.value;
        const conferma = confermaInput.value;

        if (username === '') {
            return 'Inserisci uno username.';
        }
        if (username.length < 3 || username.length > 30) {
            return 'Lo username deve avere tra 3 e 30 caratteri.';
        }
        if (!/^[A-Za-z0-9_.-]+$/.test(username)) {
            return 'Lo username può contenere solo lettere, numeri, punto, trattino e underscore.';
        }
        if (password === '') {
            return 'Inserisci una password.';
        }
        if (password.length < 8 || password.length > 72) {
            return 'La password deve avere tra 8 e 72 caratteri.';
        }
        if (!/[a-z]/.test(password) || !/[A-Z]/.test(password) ||
            !/[0-9]/.test(password) || !/[\W_]/.test(password)) {
            return 'Password insicura: servono maiuscola, minuscola, numero e carattere speciale.';
        }
        if (conferma === '') {
            return 'Conferma la password.';
        }
        if (password !== conferma) {
            return 'Le password non corrispondono.';
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

    usernameInput.addEventListener('input', onInput);
    passwordInput.addEventListener('input', onInput);
    confermaInput.addEventListener('input', onInput);
    form.addEventListener('submit', onSubmit);
})();
