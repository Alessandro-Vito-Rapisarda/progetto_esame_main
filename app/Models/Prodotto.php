<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodotto extends Model
{
    protected $table = 'prodotti';

    protected $fillable = [
        'nome',
        'descrizione',
        'prezzo'
    ];

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

}