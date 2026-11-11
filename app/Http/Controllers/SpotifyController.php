<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class SpotifyController extends Controller
{
    // Restituisce al browser solo il token Spotify (le chiavi restano sul server)
    public function getToken()
    {
        $clientId = config('services.spotify.client_id');
        $clientSecret = config('services.spotify.client_secret');

        if (!$clientId || !$clientSecret) {
            return response()->json(['error' => 'Chiavi Spotify non configurate'], 503);
        }

        try {
            $risposta = Http::asForm()
                ->withBasicAuth($clientId, $clientSecret)
                ->timeout(10)
                ->post('https://accounts.spotify.com/api/token', ['grant_type' => 'client_credentials']);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Spotify non raggiungibile'], 502);
        }

        if (!$risposta->successful() || !$risposta->json('access_token')) {
            return response()->json(['error' => 'Token Spotify non ottenuto'], 502);
        }

        return response()->json([
            'access_token' => $risposta->json('access_token'),
            'expires_in' => $risposta->json('expires_in'),
        ]);
    }
}
