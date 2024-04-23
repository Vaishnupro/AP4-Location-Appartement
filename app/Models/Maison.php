<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maison extends Logement
{
    protected $fillable = [
        'jardin',
        'superficie',
        'piscine',
        'garage',
    ];
}
