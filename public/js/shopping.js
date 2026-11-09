const BASE_URL = 'http://127.0.0.1:8000';
const shoppingItemsDiv = document.querySelector('#shopping-items');
const metaToken = document.querySelector('meta[name="csrf-token"]');
const csrfToken = metaToken.content;


function onResponse(response) {
    if (!response.ok) {
        console.log('Risposta non valida');
        return null;
    }
    return response.json();
}

function onError(error) {
    console.log('Error: ' + error);
    if (shoppingItemsDiv) {
        shoppingItemsDiv.innerHTML = '';
        const errorMsg = document.createElement('p');
        errorMsg.textContent = 'Errore di caricamento. Riprova più tardi.';
        errorMsg.classList.add('error-msg');
        shoppingItemsDiv.appendChild(errorMsg);
    }
}

function onRemoveSuccess(data) {
    if (data) {
        loadCart();
    } 
}

function onUpdateSuccess(data) {
    if (data) {
        setTimeout(loadCart, 500);
    }
}



function onCartJson(json) {
    const divTotale = document.querySelector('#subTotale');

    if(shoppingItemsDiv){
        shoppingItemsDiv.innerHTML = '';
    }

    if(divTotale) {
        divTotale.innerHTML = ''; 
    }

    if (!json || !json.cart || json.cart.length === 0) {
        const emptyMsg = document.createElement('h3');
        const divMsg = document.createElement('div');
        divMsg.classList.add('empty-cart-message');
        const descMsg = document.createElement('p');
        descMsg.textContent = 'Che ne dici di guardare qualcosa nello store ?';
        emptyMsg.textContent = 'La shopping bag è vuota.';
        const cartIcon = document.createElement('span');
        cartIcon.classList.add('material-symbols-outlined');
        cartIcon.innerHTML = '&#128722;';
        divMsg.appendChild(cartIcon);
        divMsg.appendChild(emptyMsg);
        divMsg.appendChild(descMsg);
        shoppingItemsDiv.appendChild(divMsg);
        return;
    }
    const prodotti = json.cart;
    for (const item of prodotti) {
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('cart-item');
        if (item.foto) {
            const img = document.createElement('img');
            img.src = item.foto;
            img.alt = item.nome;
            img.classList.add('cart-item-img');
            itemDiv.appendChild(img);
        }
        const detailsDiv = document.createElement('div');
        const nameStrong = document.createElement('strong');
        nameStrong.textContent = item.nome;
        detailsDiv.appendChild(nameStrong);
        detailsDiv.appendChild(document.createElement('br'));
        const qtaLabel = document.createElement('span');
        qtaLabel.textContent = 'Quantità: ';
        const removeBtn = document.createElement('button');
        removeBtn.textContent = 'Rimuovi';
        removeBtn.classList.add('remove-btn');
        removeBtn.dataset.id = item.id;
        detailsDiv.appendChild(removeBtn);
        const price = document.createElement('p');
        price.textContent = 'Prezzo: ' + item.prezzo;
        const subTotale = document.createElement('p');
        subTotale.textContent = 'SubTotale: '+ parseFloat(item.subtotale).toFixed(2);
        const inputQta = document.createElement('input');
        inputQta.type = 'number';
        inputQta.classList.add('qta-input');
        inputQta.dataset.id = item.id;
        inputQta.value = item.quantita;
        inputQta.min = '1';
        detailsDiv.appendChild(price);
        detailsDiv.appendChild(subTotale);
        detailsDiv.appendChild(qtaLabel);
        detailsDiv.appendChild(inputQta);
        itemDiv.appendChild(detailsDiv); 
        shoppingItemsDiv.appendChild(itemDiv);
    }
    const totale = document.createElement('h4');
    totale.textContent = 'Totale: ' + parseFloat(json.totale).toFixed(2);
    divTotale.appendChild(totale);
}

function loadCart() {
    fetch(BASE_URL + '/shopping', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(onResponse, onError)
    .then(onCartJson);
}


function onRemoveClick(e){
const target = e.target;

if(target.classList.contains('remove-btn')){
    const prodottoId = target.dataset.id;

    fetch(BASE_URL + '/shopping/remove?prodotto_id=' + prodottoId, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(onResponse, onError)
    .then(onRemoveSuccess);
}
}


function onQuantityChange(e){
    const target = e.target;

    if (target.classList.contains('qta-input')){
        const prodottoId = target.dataset.id;
        const quantita = parseInt(target.value);

        if(quantita > 0){
            const bodyData = JSON.stringify({
                prodotto_id: prodottoId,
                quantita: quantita
            });

    fetch(BASE_URL + '/shopping/update', {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: bodyData
    })
    .then(onResponse, onError)
    .then(onUpdateSuccess);
    }
}
}

if(shoppingItemsDiv){
    shoppingItemsDiv.addEventListener('click', onRemoveClick);
    shoppingItemsDiv.addEventListener('click', onQuantityChange);
}

loadCart();