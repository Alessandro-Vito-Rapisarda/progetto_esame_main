<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use App\Models\Prodotto;

class CarrelloProdotti extends Model
{
    protected $table = 'carrello_prodotti';
    protected $fillable = ['carrello_id', 'prodotto_id', 'quantita'];
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;

    public function prodotto()
    {
        return $this->belongsTo(Prodotto::class, 'prodotto_id');
    }

    public function carrello()
    {
        return $this->belongsTo(Carrello::class, 'carrello_id');
    }
}

