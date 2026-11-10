const BASE_URL = window.location.origin;
const IMG_URL = window.location.origin + '/';

function onResponse(response) {
    if (!response.ok) {
        return null;
    }
    return response.json();
}

function onError(error) {
    console.error('Error:', error);
    mostraMessaggioCarrello('Errore di connessione.', true);
}

function mostraMessaggioCarrello(msg, isError) {
    let msgDiv = document.querySelector('#carrello-msg');

    if (!msgDiv) {
        msgDiv = document.createElement('div');
        msgDiv.id = 'carrello-msg';
        document.body.appendChild(msgDiv);
    }

    msgDiv.textContent = msg;
    msgDiv.className = 'carrello-msg';

    if (isError) {
        msgDiv.classList.add('carrello-msg-errore');
    } else {
        msgDiv.classList.add('carrello-msg-success');
    }

    msgDiv.classList.add('show');

    setTimeout(function() {
        msgDiv.classList.remove('show');
    }, 2000);
}

function onCartJson(data) {
    if (!data) {
        mostraMessaggioCarrello('Errore di comunicazione col server.', true);
        return;
    }

    if (data.error) {
        mostraMessaggioCarrello('Errore: ' + data.error, true);
    } else {
        mostraMessaggioCarrello('Prodotto aggiunto al carrello!', false);
    }
}

function aggiungiAlCarrello(prodottoId) {
    const metaToken = document.querySelector('meta[name="csrf-token"]');
    const token = metaToken ? metaToken.content : '';

    const postData = {
        prodotto_id: prodottoId,
        quantita: 1
    };

    fetch(BASE_URL + '/shopping/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify(postData)
    })
    .then(onResponse, onError)
    .then(onCartJson);
}

// ============================================
// PAGINA LISTA PRODOTTI (Store)
// Layout con CSS Grid puro (senza Bootstrap)
// ============================================
const listaContainer = document.querySelector('#prodotti-container');

if (listaContainer) {
    function onProductsJson(data) {
        if (!data || !data.prodotti || data.prodotti.length === 0) {
            listaContainer.innerHTML = '<p class="prodotti-vuoti">Nessun prodotto disponibile al momento nello store.</p>';
            return;
        }

        const prodotti = data.prodotti;
        listaContainer.innerHTML = '';

        for (let i = 0; i < prodotti.length; i++) {
            const prodotto = prodotti[i];

            // Card singola con Flexbox/Grid puro
            const card = document.createElement('div');
            card.classList.add('prodotto-card');

            const link = document.createElement('a');
            link.href = BASE_URL + '/prodotto/' + prodotto.id;
            link.classList.add('dettaglio-link');

            if (prodotto.immagine_url) {
                const img = document.createElement('img');
                const cleanImg = prodotto.immagine_url.replace(/^\//, '');
                img.src = IMG_URL + cleanImg;
                img.alt = prodotto.nome;
                img.classList.add('prodotto-img');
                link.appendChild(img);
            }

            const divNome = document.createElement('div');
            divNome.classList.add('prodotto-nome');
            divNome.textContent = prodotto.nome;
            link.appendChild(divNome);

            const divPrezzo = document.createElement('div');
            divPrezzo.classList.add('prodotto-prezzo');
            const prezzoNum = parseFloat(prodotto.prezzo);
            divPrezzo.textContent = (isNaN(prezzoNum) ? prodotto.prezzo : prezzoNum.toFixed(2)) + ' €';
            link.appendChild(divPrezzo);

            const divDesc = document.createElement('div');
            divDesc.classList.add('prodotto-desc');
            divDesc.textContent = prodotto.descrizione || '';
            link.appendChild(divDesc);

            card.appendChild(link);

            const btn = document.createElement('button');
            btn.classList.add('prodotto-btn', 'add-to-cart-btn');
            btn.textContent = 'Aggiungi al carrello';
            btn.dataset.id = prodotto.id;

            card.appendChild(btn);

            // Inserimento diretto nel contenitore Grid
            listaContainer.appendChild(card);
        }
    }

    fetch(BASE_URL + '/prodotti/json')
        .then(onResponse, onError)
        .then(onProductsJson);

    function onContainerClick(event) {
        const target = event.target;
        if (target.classList.contains('add-to-cart-btn')) {
            const prodottoId = target.dataset.id;
            aggiungiAlCarrello(prodottoId);
        }
    }

    listaContainer.addEventListener('click', onContainerClick);
}

// ============================================
// PAGINA DETTAGLIO PRODOTTO
// ============================================
const dettaglioContainer = document.querySelector('#dettaglio-prodotto');

if (dettaglioContainer) {
    const id = dettaglioContainer.dataset.id;

    function onDetailJson(prodotto) {
        if (!prodotto) return;

        dettaglioContainer.innerHTML = '';

        const card = document.createElement('div');
        card.classList.add('prodotto-card', 'prodotto-card-center');

        if (prodotto.immagine_url) {
            const img = document.createElement('img');
            const cleanImg = prodotto.immagine_url.replace(/^\//, '');
            img.src = IMG_URL + cleanImg;
            img.alt = prodotto.nome;
            img.classList.add('prodotto-img');
            card.appendChild(img);
        }

        const divNome = document.createElement('div');
        divNome.classList.add('prodotto-nome', 'prodotto-nome-big');
        divNome.textContent = prodotto.nome;
        card.appendChild(divNome);

        const divPrezzo = document.createElement('div');
        divPrezzo.classList.add('prodotto-prezzo', 'prodotto-prezzo-big');
        const prezzoNum = parseFloat(prodotto.prezzo);
        divPrezzo.textContent = (isNaN(prezzoNum) ? prodotto.prezzo : prezzoNum.toFixed(2)) + ' €';
        card.appendChild(divPrezzo);

        const divDesc = document.createElement('div');
        divDesc.classList.add('prodotto-desc');
        divDesc.textContent = prodotto.descrizione;
        card.appendChild(divDesc);

        const btn = document.createElement('button');
        btn.classList.add('prodotto-btn', 'add-to-cart-btn');
        btn.textContent = 'Aggiungi al carrello';

        function onBtnClick() {
            aggiungiAlCarrello(prodotto.id);
        }
        btn.addEventListener('click', onBtnClick);

        card.appendChild(btn);
        dettaglioContainer.appendChild(card);
    }

    fetch(BASE_URL + '/prodotto/' + id + '/json')
        .then(onResponse, onError)
        .then(onDetailJson);
}
