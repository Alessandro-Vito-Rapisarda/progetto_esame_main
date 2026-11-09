<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Carrello;
use App\Models\Ordine;
use App\Models\OrdineProdotti;

class CheckoutController extends BaseController
{
    public function showForm(Request $request)
    {
        $utenteId = \Session::get('user_id');
        if (!$utenteId) {
            return redirect('login');
        }
        $carrello = Carrello::where('utente_id', $utenteId)->first();
        $prodotti = $carrello->prodotti()->with(['immagini'])->get();
        
        return view('checkout', ['cart' => $prodotti]);
    }

    public function processOrder(Request $request)
    {
        $utenteId = \Session::get('user_id');
        if (!$utenteId) {
            return redirect('login');
        }
        $carrello = Carrello::where('utente_id', $utenteId)->first();
        if (!$carrello || $carrello->prodotti()->count() == 0) {
            return redirect('checkout')->with('error', 'Carrello vuoto');
        }


        $ordine = Ordine::create([
            'utente_id' => $utenteId,
            'totale' => $carrello->prodotti->sum(function($p) {
                return $p->prezzo * $p->pivot->quantita;
            }),
            'data_ordine' => now(),
        ]);
        foreach ($carrello->prodotti as $prodotto) {
            OrdineProdotti::create([
                'ordine_id' => $ordine->id,
                'prodotto_id' => $prodotto->id,
                'quantita' => $prodotto->pivot->quantita,
                'prezzo_unitario' => isset($prodotto->prezzo) ? $prodotto->prezzo : 0
            ]);
        }


    $carrello->prodotti()->detach();
    
    }
}