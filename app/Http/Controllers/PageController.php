<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function spotifyAlbum()
    {
        return view('spotify');
    }

    public function spotifySongs()
    {
        return view('spotify-canzoni');
    }

    public function fakestore()
    {
        return view('fakestore');
    }
}
