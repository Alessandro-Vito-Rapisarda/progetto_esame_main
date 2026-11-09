<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImmagineProdotto extends Model
{
    protected $table = 'immagini_prodotti';
    protected $fillable = ['prodotto_id', 'url'];

    public function prodotto() {
        return $this->belongsTo(Prodotto::class, 'prodotto_id');
    }
}
