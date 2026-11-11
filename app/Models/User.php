<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'utenti';
    protected $fillable = ['username', 'password'];
    protected $hidden = ['password'];

    public function carrelli()
    {
        return $this->hasMany(Carrello::class, 'utente_id');
    }

    public function ordini()
    {
        return $this->hasMany(Ordine::class, 'utente_id');
    }
}
