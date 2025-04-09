<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokument extends Model
{
    protected $fillable = ['gazdinstvo_id', 'naziv', 'putanja', 'tip'];

    public function gazdinstvo()
    {
        return $this->belongsTo(Gazdinstvo::class);
    }
}
