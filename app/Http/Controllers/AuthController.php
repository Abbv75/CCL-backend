<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'login' => 'required|string',
                'motDePasse' => 'required|string',
            ]);

            $user = User::where('login', $validated['login'])->first();

            if (!$user || !Hash::check($validated['motDePasse'], $user->motDePasse)) {
                return response()->json([
                    'message' => 'Identifiants invalides.'
                ], 401);
            }

            return response()->json([
                'message' => 'Connexion réussie.',
                'data' => $user->load('role', 'contact')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la connexion.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
