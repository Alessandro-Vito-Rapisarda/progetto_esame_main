const form = document.querySelector('form');
const msgElem = document.querySelector('#msg');
const usernameInput = document.querySelector('#username');
const passwordInput = document.querySelector('#password');
const confermaInput = document.querySelector('#conferma');

const REGISTER_URL = 'http://127.0.0.1:8000/register';
const LOGIN_URL = 'http://127.0.0.1:8000/login';

function clearMessage() {
    if (msgElem.textContent) {
        msgElem.textContent = '';
    }
}

usernameInput.addEventListener('input', clearMessage);
passwordInput.addEventListener('input', clearMessage);
confermaInput.addEventListener('input', clearMessage);

function onResponse(response) {
    if (response.redirected) {
        window.location.href = response.url;
        return null;
    }
    return response.json();
}

function onError(error) {
    console.log('Error: ' + error);
    msgElem.textContent = 'Errore di connessione.';
    msgElem.classList.add("msg");
}

function onRegisterJson(data) {
    if (!data) {
        return;
    }
    if (data.success || data.id) {
        window.location.href = LOGIN_URL;
    } else {
        let messaggio = data.message || 'Errore durante la registrazione';
        if (data.errors) {
            for (let key in data.errors) {
                messaggio = data.errors[key][0];
                break;
            }
        }
        msgElem.textContent = messaggio;
    }
}

function onSubmit(e) {
    e.preventDefault();
    let valid = true;
    let msg = '';
    const username = usernameInput.value.trim();
    const password = passwordInput.value;
    const conferma = confermaInput.value;
    const regexLower = /[a-z]/;
    const regexUpper = /[A-Z]/;
    const regexNumber = /[0-9]/;
    const regexSpecial = /[\W_]/;
    if (!username || !password || !conferma) {
        valid = false;
        msg = 'Compilare tutti i campi';
    } else if (password !== conferma) {
        valid = false;
        msg = 'Le password non corrispondono';
    } else if (
        password.length < 8 ||
        !regexLower.test(password) ||
        !regexUpper.test(password) ||
        !regexNumber.test(password) ||
        !regexSpecial.test(password)
    ) {
        valid = false;
        msg = 'La password non rispetta i requisiti di sicurezza';
    }
    if (!valid) {
        msgElem.textContent = msg;
        msgElem.classList.add('msg');
    } else {
        const formData = new FormData(form);
        const tokenInput = document.querySelector('input[name="_token"]');
        const csrfToken = tokenInput.value;
        fetch(REGISTER_URL, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        })
        .then(onResponse, onError)
        .then(onRegisterJson);
    }
}

form.addEventListener('submit', onSubmit);