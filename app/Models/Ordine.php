<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordine extends Model
{
    protected $table = 'ordini';
    protected $fillable = ['utente_id', 'totale', 'data_ordine', 'stato', 'indirizzo_spedizione'];
    public $timestamps = false;

    public function utente()
    {
        return $this->belongsTo(User::class, 'utente_id');
    }

    public function ordineProdotti()
    {
        return $this->hasMany(OrdineProdotti::class, 'ordine_id');
    }

    // Crea l'ordine a partire dal carrello e lo svuota (da chiamare in transazione)
    public static function daCarrello(Carrello $carrello, string $indirizzo): self
    {
        $ordine = self::create([
            'utente_id' => $carrello->utente_id,
            'totale' => $carrello->totale(),
            'data_ordine' => now(),
            'indirizzo_spedizione' => $indirizzo,
        ]);

        foreach ($carrello->prodotti as $prodotto) {
            OrdineProdotti::create([
                'ordine_id' => $ordine->id,
                'prodotto_id' => $prodotto->id,
                'quantita' => $prodotto->pivot->quantita,
                'prezzo_unitario' => $prodotto->prezzo,
            ]);
        }

        $carrello->svuota();

        return $ordine;
    }
}
