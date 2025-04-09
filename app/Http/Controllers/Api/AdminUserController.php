<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        return User::select('id', 'name', 'email', 'role', 'created_at')->get();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:superadmin,admin,autor,korisnik'
        ]);

        $user = User::findOrFail($id);

        if ($user->role === 'superadmin') {
            return response()->json(['message' => 'Ne možete menjati SuperAdmin nalog.'], 403);
        }

        $user->role = $request->role;
        $user->save();

        return response()->json(['message' => 'Uloga korisnika uspešno ažurirana.']);
    }
}
