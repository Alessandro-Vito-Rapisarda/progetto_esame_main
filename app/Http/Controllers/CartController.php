<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Carrello;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function carrello(Request $request): Carrello
    {
        return Carrello::perUtente((int) $request->session()->get('user_id'));
    }

    // Risposta comune: JSON per le chiamate fetch, redirect per i form classici
    private function risposta(Request $request, Carrello $carrello, string $messaggio)
    {
        $carrello->load('prodotti');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $messaggio,
                'articoli' => $carrello->numeroArticoli(),
                'totale' => $carrello->totale(),
            ]);
        }

        return redirect()->back()->with('status', $messaggio);
    }

    public function index(Request $request)
    {
        $carrello = $this->carrello($request);
        $carrello->load('prodotti.immagini');

        return view('shopping', ['prodotti' => $carrello->prodotti, 'totale' => $carrello->totale()]);
    }

    public function add(CartRequest $request)
    {
        $carrello = $this->carrello($request);
        $carrello->aggiungi((int) $request->input('prodotto_id'), (int) $request->input('quantita', 1));

        return $this->risposta($request, $carrello, 'Prodotto aggiunto al carrello!');
    }

    public function update(CartRequest $request)
    {
        $carrello = $this->carrello($request);
        $carrello->imposta((int) $request->input('prodotto_id'), (int) $request->input('quantita', 1));

        return $this->risposta($request, $carrello, 'Quantità aggiornata.');
    }

    public function remove(CartRequest $request)
    {
        $carrello = $this->carrello($request);
        $carrello->rimuovi((int) $request->input('prodotto_id'));

        return $this->risposta($request, $carrello, 'Prodotto rimosso dal carrello.');
    }
}
