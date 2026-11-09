
const container = document.querySelector('#album-container');

const searchForm = document.createElement('form');
searchForm.classList.add('spotify-search-form-centered');

const input = document.createElement('input');
input.type = 'text';
input.id = 'album-id-input';
input.classList.add('spotify-search-input');
input.placeholder = 'Cerca album...';
input.required = true;

const button = document.createElement('button');
button.type = 'submit';
button.classList.add('spotify-search-btn');
button.textContent = 'Cerca';

searchForm.appendChild(input);
searchForm.appendChild(button);

if (container && container.parentNode) {
    container.parentNode.insertBefore(searchForm, container);
    container.classList.add('hidden'); 
}

function onTokenResponse(response) {
    if (!response.ok) return null;
    return response.json();
}

function onTokenData(data) {
    if (!data || !data.access_token) return null;
    return data.access_token;
}

function requestToken() {
    return fetch('/spotify/token')
        .then(onTokenResponse)
        .then(onTokenData);
}


function onResponse(response) {
    if (!response.ok) {
        console.log('Risposta non valida'); 
        return null; 
    }
    return response.json();
}

function onError(error) {
    console.log('Error: ' + error);
    if (container) {
        container.innerHTML = '';
        const p = document.createElement('p');
        p.textContent = 'Errore di connessione: ' + error;
        container.appendChild(p);
    }
}


function onSearchJson(data) {
    container.innerHTML = ''; 
    container.classList.remove('hidden');

    if (!data || !data.albums || !data.albums.items.length) {
        const p = document.createElement('p');
        p.textContent = 'Nessun album trovato.';
        container.appendChild(p);
        return;
    }

    const h3 = document.createElement('h3');
    h3.textContent = 'Risultati:';
    container.appendChild(h3);

    const listDiv = document.createElement('div');
    listDiv.classList.add('spotify-result-list');

    const albums = data.albums.items;
    
    for (const album of albums) {
        const card = document.createElement('div');
        card.classList.add('spotify-result-card');
        card.dataset.albumId = album.id; 

        const img = document.createElement('img');
        if (album.images && album.images.length > 0) {
            img.src = album.images[0].url;
        }
        img.alt = album.name;
        img.classList.add('spotify-result-img');
        card.appendChild(img);

        const infoDiv = document.createElement('div');
        infoDiv.classList.add('spotify-result-info');

        const titleDiv = document.createElement('div');
        titleDiv.classList.add('spotify-result-title');
        titleDiv.textContent = album.name;
        infoDiv.appendChild(titleDiv);

        const artistDiv = document.createElement('div');
        artistDiv.classList.add('spotify-result-artist');
        let artistNames = [];
        for (const artist of album.artists) {
            artistNames.push(artist.name);
        }
        artistDiv.textContent = artistNames.join(', ');
        infoDiv.appendChild(artistDiv);

        const dateDiv = document.createElement('div');
        dateDiv.classList.add('spotify-result-meta');
        dateDiv.textContent = album.release_date;
        infoDiv.appendChild(dateDiv);

        card.appendChild(infoDiv);
        card.addEventListener('click', onCardClick);
        
        listDiv.appendChild(card);
    }
    container.appendChild(listDiv);
}

function searchAlbums(query) {

    function onTokenReceived(token) {
        const url = 'https://api.spotify.com/v1/search?type=album&q=' + encodeURIComponent(query);
        
        fetch(url, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        })
        .then(onResponse, onError)
        .then(onSearchJson);
    }

    requestToken().then(onTokenReceived);
}

function onSubmit(e) {
    e.preventDefault();
    const query = input.value.trim();
    if (!query) {
        container.classList.add('hidden');
        return;
    }
    
    container.classList.remove('hidden');
    container.textContent = 'Caricamento...';
    
    searchAlbums(query);
}

searchForm.addEventListener('submit', onSubmit);



function onAlbumDetailsJson(data) {
    if (!data) {
        container.innerHTML = '';
        const p = document.createElement('p');
        p.textContent = 'Impossibile caricare i dettagli dell\'album.';
        container.appendChild(p);
        return;
    }

    container.innerHTML = ''; 

    const backBtn = document.createElement('a');
    backBtn.href = '#';
    backBtn.classList.add('spotify-back-btn');
    backBtn.textContent = 'Torna ai risultati';
    
    backBtn.addEventListener('click', function(e) {
        e.preventDefault();
        searchForm.dispatchEvent(new Event('submit'));
    });
    container.appendChild(backBtn);

    const albumCard = document.createElement('div');
    albumCard.classList.add('spotify-album-card');

    const infoDiv = document.createElement('div');
    infoDiv.classList.add('spotify-album-info');

    const titleDiv = document.createElement('div');
    titleDiv.classList.add('spotify-album-title');
    titleDiv.textContent = data.name;
    infoDiv.appendChild(titleDiv);

    const metaArtist = document.createElement('div');
    metaArtist.classList.add('spotify-album-meta');
    let artists = [];
    if (data.artists) {
        for(const art of data.artists) artists.push(art.name);
    }
    metaArtist.textContent = 'Artista: ' + artists.join(', ');
    infoDiv.appendChild(metaArtist);

    const metaDate = document.createElement('div');
    metaDate.classList.add('spotify-album-meta');
    metaDate.textContent = 'Data di rilascio: ' + data.release_date;
    infoDiv.appendChild(metaDate);

    albumCard.appendChild(infoDiv);

    if (data.images && data.images.length > 0) {
        const cover = document.createElement('img');
        cover.src = data.images[0].url;
        cover.alt = data.name;
        cover.classList.add('spotify-album-cover');
        albumCard.appendChild(cover);
    }
    container.appendChild(albumCard);

    const tracksContainer = document.createElement('div');
    tracksContainer.classList.add('spotify-album-tracks');

    const tracksTitle = document.createElement('div');
    tracksTitle.classList.add('spotify-album-tracks-title');
    tracksTitle.textContent = 'Tracce:';
    tracksContainer.appendChild(tracksTitle);

    const ul = document.createElement('ul');
    ul.classList.add('spotify-album-tracks-list');

    if (data.tracks && data.tracks.items) {
        for (const track of data.tracks.items) {
            const li = document.createElement('li');
            
            const minutes = Math.floor(track.duration_ms / 60000);
            let seconds = Math.floor((track.duration_ms % 60000) / 1000);
            const secondsStr = seconds < 10 ? '0' + seconds : seconds;

            li.textContent = track.track_number + '. ' + track.name + ' (' + minutes + ':' + secondsStr + ')';
            ul.appendChild(li);
        }
    }
    tracksContainer.appendChild(ul);
    container.appendChild(tracksContainer);
}

function onCardClick(event) {
    const card = event.currentTarget; 
    const albumId = card.dataset.albumId;

    container.innerHTML = '';
    const p = document.createElement('p');
    p.textContent = 'Caricamento album...';
    container.appendChild(p);

    function onTokenReceived(token) {
        const url = 'https://api.spotify.com/v1/albums/' + albumId;

        fetch(url, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        })
        .then(onResponse, onError)
        .then(onAlbumDetailsJson);
    }

    requestToken().then(onTokenReceived);
}