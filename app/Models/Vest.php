<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vest extends Model
{
    protected $fillable = ['naslov', 'sadrzaj', 'kategorija', 'autor_id'];

    public function autor()
    {
        return $this->belongsTo(User::class, 'autor_id');
    }
}
