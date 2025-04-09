<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KontaktPoruka;
use Illuminate\Support\Facades\Mail;

class KontaktController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'ime' => 'required|string|max:255',
            'email' => 'required|email',
            'poruka' => 'required|string',
        ]);

        // snimi poruku u bazu
        KontaktPoruka::create($request->only('ime', 'email', 'poruka'));

        // pošalji email (ovde možeš staviti više adresa)
        Mail::raw("Nova poruka sa sajta:\n\nIme: {$request->ime}\nEmail: {$request->email}\n\nPoruka:\n{$request->poruka}", function ($message) {
            $message->to(['radojebozic1966@gmail.com', 'miroslavbozic1988@gmail.com'])
                    ->subject('Kontakt forma – AGRO BiM');
        });

        return response()->json(['message' => 'Poruka je poslata i sačuvana.']);
    }

    // (opciono) poslednjih 15 poruka
    public function poslednje()
    {
        return KontaktPoruka::latest()->take(15)->get();
    }
}
