<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;



class SpotifyController extends BaseController
{
    public function getToken()
    {
        $clientId = env('SPOTIFY_PUBLISHABLE_KEY');
        $clientSecret = env('SPOTIFY_SECRET_KEY');

        $url = 'https://accounts.spotify.com/api/token'; 

        $curl = curl_init();

        
        curl_setopt($curl, CURLOPT_URL, $url);
        
        curl_setopt($curl, CURLOPT_POST, 1);

       
        curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        
        $headers = array(
            "Authorization: Basic " . base64_encode($clientId . ":" . $clientSecret),
            "Content-Type: application/x-www-form-urlencoded"
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

       
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, value: 1);

        $result = curl_exec($curl);
        
        curl_close($curl);

    
        $jsonResponse = json_decode($result, true);

        return response()->json($jsonResponse);
    }
}