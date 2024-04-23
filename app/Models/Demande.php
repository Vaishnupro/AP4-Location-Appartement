<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'appartement_id',
        'nom',
        'prenom',
        'numero_telephone',
        'email',
        'arrivee',
        'depart',
        'id_demandeur',
    ];

    public function appartement()
    {
        return $this->hasOne('App\Models\Appartement', 'id', 'appartement_id');
    }
}
