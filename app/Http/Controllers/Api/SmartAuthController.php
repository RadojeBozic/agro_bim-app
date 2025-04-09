<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SmartUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SmartAuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:smart_users,email',
            'password' => 'required|string|confirmed|min:6',
            'birth_date' => 'nullable|date',
            'gender' => 'in:muško,žensko,ne želim',
            'newsletter' => 'boolean',
            'accepted_terms' => 'required|accepted',
        ]);
    
        $role = 'kupac'; // defaultna uloga
    
        if (in_array($request->email, [
            'radojebozic1966@gmail.com',
            'miroslavbozic1988@gmail.com'
        ])) {
            $role = 'admin';
        }
    
        $user = SmartUser::create([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'birth_date'     => $request->birth_date,
            'gender'         => $request->gender ?? 'ne želim',
            'newsletter'     => $request->newsletter ?? false,
            'accepted_terms' => $request->accepted_terms,
            'role'           => $role,
        ]);
    
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = SmartUser::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Pogrešan email ili lozinka.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Uspešno ste se odjavili.'
        ]);
    }
}
