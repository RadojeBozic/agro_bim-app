<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VestController extends Controller
{
    public function index()
    {
        return Vest::with('autor')->latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'naslov' => 'required|string|max:255',
            'sadrzaj' => 'required|string',
            'kategorija' => 'nullable|string|max:100',
        ]);

        $vest = Vest::create([
            'naslov' => $request->naslov,
            'sadrzaj' => $request->sadrzaj,
            'kategorija' => $request->kategorija ?? 'agrar',
            'autor_id' => Auth::id(),
        ]);

        return response()->json($vest, 201);
    }

    public function update(Request $request, Vest $vest)
    {
        $vest->update($request->only(['naslov', 'sadrzaj', 'kategorija']));
        return response()->json(['message' => 'Vest ažurirana.']);
    }

    public function destroy(Vest $vest)
    {
        $vest->delete();
        return response()->json(['message' => 'Vest obrisana.']);
    }
}
