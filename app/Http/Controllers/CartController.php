<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Carrello;
use App\Models\CarrelloProdotti;
use App\Models\Prodotto;

class CartController extends BaseController
{
   public function index(Request $request)
{
    $utenteId = \Session::get('user_id');

    if (!$utenteId) {
        return response()->json(['error' => 'Utente non autenticato'], 401);
    }

    $carrello = Carrello::where('utente_id', $utenteId)->first();

    if (!$carrello) {
        $carrello = Carrello::create(['utente_id' => $utenteId]);
    }

    $prodottiGrezzi = $carrello->prodotti()->with(['immagini'])->get();

    $prodotti = [];
    $totale = 0;

    foreach ($prodottiGrezzi as $prodotto) {
        
        if ($prodotto->immagini && $prodotto->immagini->count() > 0) {
            $foto = $prodotto->immagini->first()->url;
        } else if (!empty($prodotto->immagine_url)) {
            $foto = $prodotto->immagine_url;
        }

        $prezzo = $prodotto->prezzo;
        $quantita = $prodotto->pivot->quantita;
        $subtotale = $prezzo * $quantita;

        $totale += $subtotale;

        $prodotti[] = [
            'id' => $prodotto->id,
            'nome' => $prodotto->nome,
            'quantita' => $quantita,
            'foto' => $foto,
            'prezzo' => $prezzo,
            'subtotale' => $subtotale,
        ];


    }

    if ($request->ajax()) {
        return response()->json(['cart' => $prodotti, 'totale' => $totale]);
    } 

    return view('shopping', ['cart' => $prodotti, 'totale' => $totale]);
}

    public function add(Request $request)
    {
        $utenteId = \Session::get('user_id');
        if (!$utenteId) {
            return response()->json(['error' => 'Utente non autenticato'],  401);
        }
        $carrello = Carrello::firstOrCreate(['utente_id' => $utenteId]);
            $prodottoId = $request->input('prodotto_id');
            if ($prodottoId) {
                $prodotto = Prodotto::find($prodottoId);
            }
        $esistente = CarrelloProdotti::where('carrello_id', $carrello->id)
            ->where('prodotto_id', $prodotto->id)
            ->first();
        if ($esistente) {
            $nuovaQuantita = $esistente->quantita + $request->input('quantita', 1);
            CarrelloProdotti::where('carrello_id', $carrello->id)
                ->where('prodotto_id',  $prodotto->id)
                ->update(['quantita' => $nuovaQuantita]);
        } else {
            CarrelloProdotti::create([
                'carrello_id' => $carrello->id,
                'prodotto_id' => $prodotto->id,
                'quantita' => $request->input('quantita', default: 1),
            ]);
        }
        return $this->index($request);
    }


    public function remove(Request $request)
    {
        $utenteId = \Session::get('user_id');
        if (!$utenteId) {
            return response()->json( ['error' => 'Utente non autenticato'], 401);
        }
        $carrello = Carrello::where( 'utente_id', $utenteId)->first();
        $prodottoId = $request->input('prodotto_id');
        if ($carrello && $prodottoId) {
            CarrelloProdotti::where('carrello_id', $carrello->id)
                ->where('prodotto_id', $prodottoId)
                ->delete();
        }
        return $this->index($request);
    }



    public function update(Request $request)
    {
        $utenteId = \Session::get('user_id');
        if (!$utenteId) {
            return response()->json(['error' => 'Utente non autenticato'], 401);
        }
        $carrello = Carrello::where('utente_id', $utenteId)->first();
        if ($carrello) {
            $carrelloId = $carrello->id;
            $prodottoId = $request->input('prodotto_id');
            $riga = CarrelloProdotti::where('carrello_id', $carrelloId)
                ->where('prodotto_id', $prodottoId)
                ->first();
            if ($riga) {
                $nuovaQuantita = $request->input('quantita');
                if ($nuovaQuantita > 0) {
                    CarrelloProdotti::where('carrello_id', $carrelloId)
                        ->where('prodotto_id', $prodottoId)
                        ->update(['quantita' => $nuovaQuantita]);
                } else {
                    CarrelloProdotti::where('carrello_id', $carrelloId)
                        ->where('prodotto_id', $prodottoId)
                        ->delete();
                }
            }
        }
        return $this->index($request);
    }
}