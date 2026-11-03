<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Celular extends Model
{
    protected $table = 'celulares';

    protected $fillable = [
        'marca',
        'modelo',
        'precio',
        'stock'
    ];
}