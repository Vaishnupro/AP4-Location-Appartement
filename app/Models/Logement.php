<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logement extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'numero_rue',
        'rue',
        'ville',
        'code_postal',
        'image',
        'arrondissement',
        'region',
        'departement',
        'prix_loc',
        'prix_charge',
        'preavis',
        'date_libre',
        'id_proprietaire',
    ];
}
