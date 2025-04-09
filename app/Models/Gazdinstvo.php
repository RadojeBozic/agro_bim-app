<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gazdinstvo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'naziv',
        'pib',
        'maticni_broj',
        'adresa',
        'tip',
    ];

    // Veza: gazdinstvo pripada korisniku
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
