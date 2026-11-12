const productsDiv = document.querySelector('#fakestore-products');
const cartDiv = document.querySelector('#fakestore-cart');

let cart = [];
const productsById = new Map();

function renderStatus(message, withRetry = false) {
    if (!productsDiv) return;
    productsDiv.innerHTML = '';

    const box = document.createElement('div');
    box.classList.add('fakestore-status');

    const p = document.createElement('p');
    p.textContent = message;
    box.appendChild(p);

    if (withRetry) {
        const retryBtn = document.createElement('button');
        retryBtn.type = 'button';
        retryBtn.classList.add('fakestore-retry-btn');
        retryBtn.textContent = 'Riprova';
        retryBtn.addEventListener('click', loadProducts);
        box.appendChild(retryBtn);
    }

    productsDiv.appendChild(box);
}

function renderProducts(products) {
    if (!productsDiv) return;
    if (!Array.isArray(products) || products.length === 0) {
        renderStatus('Nessun prodotto disponibile su FakeStore.', true);
        return;
    }

    productsDiv.innerHTML = '';
    productsById.clear();

    for (const product of products) {
        if (!product) continue;
        productsById.set(String(product.id), product);

        const card = document.createElement('div');
        card.classList.add('product-card');

        const img = document.createElement('img');
        img.src = product.image || '';
        img.alt = product.title || 'Prodotto';
        img.classList.add('product-img');
        card.appendChild(img);

        const h4 = document.createElement('h4');
        h4.textContent = product.title || 'Prodotto';
        card.appendChild(h4);

        const p = document.createElement('p');
        p.textContent = (product.price ?? '0') + ' €';
        card.appendChild(p);

        const btnDiv = document.createElement('div');
        btnDiv.classList.add('fakestore-add-btn');

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.textContent = 'Aggiungi al carrello';
        btn.dataset.id = String(product.id);
        btnDiv.appendChild(btn);

        card.appendChild(btnDiv);
        productsDiv.appendChild(card);
    }
}

async function loadProducts() {
    renderStatus('Caricamento prodotti...');
    try {
        const signal = typeof AbortSignal !== 'undefined' && typeof AbortSignal.timeout === 'function'
            ? AbortSignal.timeout(15000)
            : undefined;
        const response = await fetch('/fakestore/products', { signal });
        if (!response.ok) {
            throw new Error('HTTP ' + response.status);
        }
        const products = await response.json();
        renderProducts(products);
    } catch (error) {
        renderStatus('Impossibile caricare i prodotti da FakeStore al momento.', true);
    }
}

function onProductClick(e) {
    const target = e.target;
    if (target.tagName !== 'BUTTON' || !target.dataset.id) {
        return;
    }

    const product = productsById.get(String(target.dataset.id));
    if (product) {
        cart.push(product);
        renderCart();
    }
}

function renderCart() {
    if (!cartDiv) return;
    cartDiv.classList.remove('hidden');
    cartDiv.innerHTML = '';

    if (cart.length === 0) {
        const emptyMsg = document.createElement('div');
        emptyMsg.classList.add('fakestore-cart-title', 'cart-empty-msg');
        emptyMsg.textContent = 'Carrello vuoto';
        cartDiv.appendChild(emptyMsg);
        return;
    }

    const titleDiv = document.createElement('div');
    titleDiv.classList.add('fakestore-cart-title');
    titleDiv.textContent = 'Carrello';
    cartDiv.appendChild(titleDiv);

    const listDiv = document.createElement('div');
    listDiv.classList.add('fakestore-cart-list');

    for (const item of cart) {
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('fakestore-cart-item');

        const spanName = document.createElement('span');
        spanName.textContent = item.title;
        itemDiv.appendChild(spanName);

        const spanPrice = document.createElement('span');
        spanPrice.textContent = item.price + ' €';
        itemDiv.appendChild(spanPrice);

        const btnRemove = document.createElement('button');
        btnRemove.type = 'button';
        btnRemove.textContent = 'Rimuovi';
        btnRemove.classList.add('fakestore-cart-remove');
        btnRemove.dataset.id = String(item.id);
        itemDiv.appendChild(btnRemove);

        listDiv.appendChild(itemDiv);
    }

    cartDiv.appendChild(listDiv);
}

function onCartClick(e) {
    const target = e.target;
    if (target.classList.contains('fakestore-cart-remove')) {
        const id = target.dataset.id;
        cart = cart.filter((item) => String(item.id) !== String(id));
        renderCart();
    }
}

if (productsDiv) {
    productsDiv.addEventListener('click', onProductClick);
}
if (cartDiv) {
    cartDiv.addEventListener('click', onCartClick);
}

loadProducts();
