<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationSuggestion extends Model
{
    use HasFactory;

    protected $table = 'sugerencias_ubicacion';

    protected $fillable = [
        'ciudad',
        'zona_barrio',
        'comentario',
    ];
}
