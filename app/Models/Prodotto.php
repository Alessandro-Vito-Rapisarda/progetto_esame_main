<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodotto extends Model
{
    protected $table = 'prodotti';
    public $timestamps = false;

    protected $fillable = ['nome', 'descrizione', 'prezzo'];

    public function immagini()
    {
        return $this->hasMany(ImmagineProdotto::class, 'prodotto_id');
    }

    public function carrelloProdotti()
    {
        return $this->hasMany(CarrelloProdotti::class, 'prodotto_id');
    }

    public function ordineProdotti()
    {
        return $this->hasMany(OrdineProdotti::class, 'prodotto_id');
    }

    // Prodotti il cui nome contiene il testo cercato (se presente)
    public function scopeCercaNome($query, ?string $nome)
    {
        if ($nome === null || $nome === '') {
            return $query;
        }
        $nome = addcslashes($nome, '%_' . chr(92));
        return $query->where('nome', 'LIKE', '%' . $nome . '%');
    }

    // Percorso (relativo a public/) dell'immagine principale
    public function getFotoAttribute(): ?string
    {
        if (!empty($this->immagine_url)) {
            return $this->immagine_url;
        }
        return $this->immagini->first()?->url;
    }
}
