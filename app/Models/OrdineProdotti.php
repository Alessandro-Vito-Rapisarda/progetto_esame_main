<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdineProdotti extends Model
{
    protected $table = 'ordine_prodotti';
    public $timestamps = false;
    protected $fillable = [
        'ordine_id',
        'prodotto_id',
        'quantita',
        'prezzo_unitario'
    ];

   
    public function ordine()
    {
        return $this->belongsTo(Ordine::class, 'ordine_id');
    }

    
    public function prodotto()
    {
        return $this->belongsTo(Prodotto::class, 'prodotto_id');
    }
}
