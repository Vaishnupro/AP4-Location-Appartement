<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Appartement extends Logement
{
    use HasFactory;

    protected $fillable = [
        'ETAGE',
        'TYPAPPART',
        'ASCENSEUR',
        'PREAVIS',
        'DATE_LIBRE',
        'id_proprietaire',
    ];
}
