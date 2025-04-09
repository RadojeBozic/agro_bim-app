<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gazdinstvo;
use Illuminate\Support\Facades\Auth;

class GazdinstvoController extends Controller
{
    // Prikaz svih gazdinstava ulogovanog korisnika
    public function index()
    {
        return response()->json(Auth::user()->gazdinstva);
    }

    // Kreiranje novog gazdinstva za prijavljenog korisnika
    public function store(Request $request)
    {
        $request->validate([
            'naziv' => 'required|string|max:255',
            'pib' => 'nullable|string|max:20',
            'maticni_broj' => 'nullable|string|max:20',
            'adresa' => 'nullable|string|max:255',
            'tip' => 'required|in:porodično,komercijalno,mešovito',
        ]);

        $gazdinstvo = Gazdinstvo::create([
            'user_id' => Auth::id(), // Vežemo za prijavljenog korisnika
            'naziv' => $request->naziv,
            'pib' => $request->pib,
            'maticni_broj' => $request->maticni_broj,
            'adresa' => $request->adresa,
            'tip' => $request->tip,
        ]);

        return response()->json($gazdinstvo, 201);
    }
}
