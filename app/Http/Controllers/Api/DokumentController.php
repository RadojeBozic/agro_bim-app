<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokument;
use Illuminate\Support\Facades\Storage;

class DokumentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'gazdinstvo_id' => 'required|exists:gazdinstvos,id',
            'naziv' => 'required|string|max:255',
            'fajl' => 'required|file|max:10240' // max 10MB
        ]);

        $path = $request->file('fajl')->store('dokumenti', 'public');

        $dokument = Dokument::create([
            'gazdinstvo_id' => $request->gazdinstvo_id,
            'naziv' => $request->naziv,
            'putanja' => $path,
            'tip' => $request->file('fajl')->getClientOriginalExtension(),
        ]);

        return response()->json($dokument, 201);
    }

    public function show($gazdinstvo_id)
    {
        return Dokument::where('gazdinstvo_id', $gazdinstvo_id)->get();
    }

    public function destroy($id)
{
    $dokument = Dokument::findOrFail($id);

    // brišemo fajl sa diska
    Storage::disk('public')->delete($dokument->putanja);

    $dokument->delete();

    return response()->json(['message' => 'Dokument je obrisan.']);
}
}

