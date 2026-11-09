
const productsDiv = document.querySelector('#fakestore-products');
const cartDiv = document.querySelector('#fakestore-cart');

let cart = [];


function onResponse(response) {
    if (!response.ok) {
        console.log('Risposta non valida');
        return null;
    }
    return response.json();
}

function onError(error) {
    console.log('Error: ' + error);
}


function onProductsJson(products) {

    productsDiv.innerHTML = '';

    for (const product of products) {
        const card = document.createElement('div');
        card.classList.add('product-card'); 

        const img = document.createElement('img');
        img.src = product.image;
        img.alt = product.title;
        img.classList.add('product-img'); 
        card.appendChild(img);

        const h4 = document.createElement('h4');
        h4.textContent = product.title;
        card.appendChild(h4);

        const p = document.createElement('p');
        p.textContent = product.price + ' €'; 
        card.appendChild(p);

        const btnDiv = document.createElement('div');
        btnDiv.classList.add('fakestore-add-btn');

        const btn = document.createElement('button');
        btn.textContent = 'Aggiungi al carrello';

        btn.dataset.id = product.id; 
        btnDiv.appendChild(btn);

        card.appendChild(btnDiv);
        productsDiv.appendChild(card);
    }
}

function loadProducts() {
    fetch('https://fakestoreapi.com/products')
        .then(onResponse, onError)
        .then(onProductsJson);
}


function onAddToCartJson(product) {
    cart.push(product); 
    renderCart();       
}

function onProductClick(e) {
    const target = e.target;
    
    if (target.tagName === 'BUTTON') {
        const id = target.dataset.id; 

        fetch('https://fakestoreapi.com/products/' + id)
            .then(onResponse, onError)
            .then(onAddToCartJson);
    }
}

productsDiv.addEventListener('click', onProductClick);



function renderCart() {
    cartDiv.classList.remove('hidden');

    cartDiv.innerHTML = '';

    if (cart.length === 0) {
        const emptyMsg = document.createElement('div');
       
        emptyMsg.classList.add('fakestore-cart-title'); 
        emptyMsg.classList.add('cart-empty-msg'); 

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
        btnRemove.textContent = 'Rimuovi';
        btnRemove.classList.add('fakestore-cart-remove');
        btnRemove.dataset.id = item.id; 
        itemDiv.appendChild(btnRemove);

        listDiv.appendChild(itemDiv);
    }

    cartDiv.appendChild(listDiv);
}


function onCartClick(e) {
    const target = e.target;
    
    if (target.classList.contains('fakestore-cart-remove')) {
        const id = target.dataset.id;
        
        
        cart = cart.filter(function(item) {
            return item.id != id;
        });
        
        renderCart();
    }
}

cartDiv.addEventListener('click', onCartClick);


loadProducts();
