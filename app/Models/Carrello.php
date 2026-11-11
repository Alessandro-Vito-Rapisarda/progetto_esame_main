<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrello extends Model
{
    public const MAX_QUANTITA = 99;

    protected $table = 'carrello';
    protected $fillable = ['utente_id'];

    public static function perUtente(int $utenteId): self
    {
        return self::firstOrCreate(['utente_id' => $utenteId]);
    }

    public function utente()
    {
        return $this->belongsTo(User::class, 'utente_id');
    }

    public function prodotti()
    {
        return $this->belongsToMany(Prodotto::class, 'carrello_prodotti', 'carrello_id', 'prodotto_id')
                    ->withPivot('quantita');
    }

    // Aggiunge una quantita' (massimo MAX_QUANTITA per prodotto)
    public function aggiungi(int $prodottoId, int $quantita): void
    {
        $riga = $this->prodotti()->where('prodotti.id', $prodottoId)->first();

        if ($riga) {
            $nuova = min(self::MAX_QUANTITA, $riga->pivot->quantita + $quantita);
            $this->prodotti()->updateExistingPivot($prodottoId, ['quantita' => $nuova]);
        } else {
            $this->prodotti()->attach($prodottoId, ['quantita' => min(self::MAX_QUANTITA, $quantita)]);
        }
    }

    public function imposta(int $prodottoId, int $quantita): void
    {
        $this->prodotti()->updateExistingPivot($prodottoId, ['quantita' => $quantita]);
    }

    public function rimuovi(int $prodottoId): void
    {
        $this->prodotti()->detach($prodottoId);
    }

    public function svuota(): void
    {
        $this->prodotti()->detach();
    }

    public function totale(): float
    {
        return (float) $this->prodotti->sum(fn ($p) => $p->prezzo * $p->pivot->quantita);
    }

    public function numeroArticoli(): int
    {
        return (int) $this->prodotti->sum(fn ($p) => $p->pivot->quantita);
    }
}
