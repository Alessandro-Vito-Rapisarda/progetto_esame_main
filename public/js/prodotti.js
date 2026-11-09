const BASE_URL = 'http://127.0.0.1:8000';
const IMG_URL = 'http://127.0.0.1:8000/';

function onResponse(response) {
    if (!response.ok) {
        return null; 
    }
    return response.json();
}

function onError(error) {
    console.log('Error: ' + error);
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
    const token = metaToken.content;

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


const listaContainer = document.querySelector('#prodotti-container');

if (listaContainer) {

    function onProductsJson(data) {
        const prodotti = data.prodotti;
        let row = null;

        for (let i = 0; i < prodotti.length; i++) {
            const prodotto = prodotti[i];

            if (i % 3 === 0) {
                row = document.createElement('div');
                row.classList.add('prodotti-row');
                listaContainer.appendChild(row);
            }

            const card = document.createElement('div');
            card.classList.add('prodotto-card');

            const link = document.createElement('a');
            link.href = BASE_URL + '/prodotto/' + prodotto.id;
            link.classList.add('dettaglio-link');

            if (prodotto.immagine_url) {
                const img = document.createElement('img');
                img.src = IMG_URL + prodotto.immagine_url;
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
            divPrezzo.textContent = prodotto.prezzo + ' €';
            link.appendChild(divPrezzo);

            const divDesc = document.createElement('div');
            divDesc.classList.add('prodotto-desc');
            divDesc.textContent = prodotto.descrizione || '';
            link.appendChild(divDesc);

            card.appendChild(link);

            const btn = document.createElement('button');
            btn.classList.add('prodotto-btn');
            btn.classList.add('add-to-cart-btn');
            btn.textContent = 'Aggiungi al carrello';
            btn.dataset.id = prodotto.id; 
            
            card.appendChild(btn);
            
            if (row) {
                row.appendChild(card);
            }
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


const dettaglioContainer = document.querySelector('#dettaglio-prodotto');

if (dettaglioContainer) {
    const id = dettaglioContainer.dataset.id;

    function onDetailJson(prodotto) {
        if (!prodotto) return;

        dettaglioContainer.innerHTML = '';

        const card = document.createElement('div');
        card.classList.add('prodotto-card');
        card.classList.add('prodotto-card-center');

        if (prodotto.immagine_url) {
            const img = document.createElement('img');
            img.src = IMG_URL + prodotto.immagine_url;
            img.alt = prodotto.nome;
            img.classList.add('prodotto-img');
            card.appendChild(img);
        }

        const divNome = document.createElement('div');
        divNome.classList.add('prodotto-nome');
        divNome.classList.add('prodotto-nome-big');
        divNome.textContent = prodotto.nome;
        card.appendChild(divNome);

        const divPrezzo = document.createElement('div');
        divPrezzo.classList.add('prodotto-prezzo');
        divPrezzo.classList.add('prodotto-prezzo-big');
        divPrezzo.textContent = prodotto.prezzo + ' €';
        card.appendChild(divPrezzo);

        const divDesc = document.createElement('div');
        divDesc.classList.add('prodotto-desc');
        divDesc.textContent = prodotto.descrizione;
        card.appendChild(divDesc);

        
        const btn = document.createElement('button');
        btn.classList.add('prodotto-btn');
        btn.classList.add('add-to-cart-btn');
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