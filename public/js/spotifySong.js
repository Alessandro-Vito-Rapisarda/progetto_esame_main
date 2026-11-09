const container = document.querySelector('#song-container');
const searchForm = document.createElement('form');
searchForm.classList.add('spotify-search-form');

const input = document.createElement('input');
input.type = 'text';
input.id = 'song-name-input';
input.classList.add('spotify-search-input');
input.placeholder = 'Cerca canzone...';
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
        p.classList.add('error-msg'); 
        container.appendChild(p);
    }
}


function onSearchJson(data) {

    container.innerHTML = ''; 
    container.classList.remove('hidden');

    if (!data || !data.tracks || !data.tracks.items.length) {
        const p = document.createElement('p');
        p.textContent = 'Nessuna canzone trovata.';
        container.appendChild(p);
        return;
    }

    const h3 = document.createElement('h3');
    h3.textContent = 'Risultati:';
    container.appendChild(h3);

    const listDiv = document.createElement('div');
    listDiv.classList.add('spotify-result-list');

    const tracks = data.tracks.items;
    for (const track of tracks) {
        const card = document.createElement('div');
        card.classList.add('spotify-result-card');
        card.dataset.trackId = track.id; 

        const img = document.createElement('img');
        if (track.album.images && track.album.images.length > 0) {
            img.src = track.album.images[0].url;
        }
        img.alt = track.name;
        img.classList.add('spotify-result-img');
        card.appendChild(img);

        const infoDiv = document.createElement('div');
        infoDiv.classList.add('spotify-result-info');

        const title = document.createElement('div');
        title.classList.add('spotify-result-title');
        title.textContent = track.name;
        infoDiv.appendChild(title);

        const artist = document.createElement('div');
        artist.classList.add('spotify-result-artist');
        let artists = [];
        for (const a of track.artists) artists.push(a.name);
        artist.textContent = artists.join(', ');
        infoDiv.appendChild(artist);

        card.appendChild(infoDiv);

        card.addEventListener('click', onTrackClick);

        listDiv.appendChild(card);
    }
    container.appendChild(listDiv);
}

function searchTracks(query) {

    function onTokenReceived(token) {
        
        const url = 'https://api.spotify.com/v1/search?q=' + encodeURIComponent(query) + '&type=track';
        
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
    container.innerHTML = '';
    const p = document.createElement('p');
    p.textContent = 'Caricamento...';
    container.appendChild(p);

    searchTracks(query);
}

searchForm.addEventListener('submit', onSubmit);




function onTrackDetailJson(data) {
    if (!data) {
        container.innerHTML = '';
        const p = document.createElement('p');
        p.textContent = 'Impossibile caricare i dettagli della canzone.';
        container.appendChild(p);
        return;
    }

    container.innerHTML = '';

    const albumCard = document.createElement('div');
    albumCard.classList.add('spotify-album-card');

    const infoDiv = document.createElement('div');
    infoDiv.classList.add('spotify-album-info');

    
    const title = document.createElement('div');
    title.classList.add('spotify-album-title');
    title.textContent = data.name;
    infoDiv.appendChild(title);

    
    const metaArtist = document.createElement('div');
    metaArtist.classList.add('spotify-album-meta');
    let artists = [];
    if(data.artists) {
        for(const a of data.artists) artists.push(a.name);
    }
    metaArtist.textContent = 'Artista: ' + artists.join(', ');
    infoDiv.appendChild(metaArtist);

    
    const metaAlbum = document.createElement('div');
    metaAlbum.classList.add('spotify-album-meta');
    metaAlbum.textContent = 'Album: ' + (data.album ? data.album.name : 'N/A');
    infoDiv.appendChild(metaAlbum);

    
    const metaDuration = document.createElement('div');
    metaDuration.classList.add('spotify-album-meta');
    const minutes = Math.floor(data.duration_ms / 60000);
    let seconds = Math.floor((data.duration_ms % 60000) / 1000);
    const secondsStr = seconds < 10 ? '0' + seconds : seconds;
    metaDuration.textContent = 'Durata: ' + minutes + ':' + secondsStr;
    infoDiv.appendChild(metaDuration);

    albumCard.appendChild(infoDiv);

  
    if (data.album && data.album.images && data.album.images.length > 0) {
        const img = document.createElement('img');
        img.src = data.album.images[0].url;
        img.alt = data.name;
        img.classList.add('spotify-album-cover');
        albumCard.appendChild(img);
    }
    container.appendChild(albumCard);

    const backBtn = document.createElement('a');
    backBtn.href = '#';
    backBtn.classList.add('spotify-back-btn');
    backBtn.textContent = 'Torna ai risultati';
    backBtn.addEventListener('click', function(e) {
        e.preventDefault();
        searchForm.dispatchEvent(new Event('submit'));
    });
    container.appendChild(backBtn);
}

function onTrackClick(event) {
    const card = event.currentTarget;
    const trackId = card.dataset.trackId;

    container.innerHTML = '';
    const p = document.createElement('p');
    p.textContent = 'Caricamento canzone...';
    container.appendChild(p);

    function onTokenReceived(token) {

        const url = 'https://api.spotify.com/v1/tracks/' + trackId;
        
        fetch(url, {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        })
        .then(onResponse, onError)
        .then(onTrackDetailJson);
    }

    requestToken().then(onTokenReceived);
}