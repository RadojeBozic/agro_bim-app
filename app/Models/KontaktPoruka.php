<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontaktPoruka extends Model
{
    protected $fillable = ['ime', 'email', 'poruka'];
}

