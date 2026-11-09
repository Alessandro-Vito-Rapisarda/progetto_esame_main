<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use App\Models\User;
use App\Models\Prodotto;

class Carrello extends Model
{
    protected $table = 'carrello';
    protected $fillable = ['utente_id'];

    public function utente()
    {
        return $this->belongsTo(User::class, 'utente_id');
    }

    public function prodotti()
    {
        return $this->belongsToMany(Prodotto::class, 'carrello_prodotti', 'carrello_id', 'prodotto_id')
                    ->withPivot('quantita');
    }
}
