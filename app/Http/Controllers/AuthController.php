<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Connexion d'un utilisateur.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'motDePasse' => 'required|string',
        ]);

        // On essaie d'authentifier l'utilisateur avec login et motDePasse
        if (!Auth::attempt(['login' => $credentials['login'], 'motDePasse' => $credentials['motDePasse']])) {
            return response()->json([
                'message' => 'Identifiants invalides.'
            ], 401);
        }

        $user = Auth::user();

        // Générer un token Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie.',
            'token' => $token,
            'user' => $user
        ]);
    }

    /**
     * Déconnexion de l'utilisateur (suppression du token courant).
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie.'
        ]);
    }
}
