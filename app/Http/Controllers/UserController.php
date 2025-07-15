<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::with('role', 'contact')->get();
            if (!$users) {
                return response()->json([
                    'message' => 'Aucun utilisateur trouvé',
                ], 404);
            }

            return response()->json([
                'message' => 'Liste des utilisateurs récupérée avec succès.',
                'data' => $users,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des utilisateurs',
                'errors' => $th->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(
                    [
                        'message' => 'Utilisateur introuvable'
                    ],
                    404
                );
            }

            return $user->load('contact', 'role');
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de la récupération de l\'utilisateur',
                'errors' => $th->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nomComplet' => 'required',
                'login' => 'required|unique:users,login',
                'motDePasse' => 'required',
                'idCOD' => 'nullable|unique:users,idCOD',
                'id_role' => 'required|exists:roles,id',
                'telephone' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erreur de validation des champs',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $contact = Contact::create($request->all());

            if (!$contact) {
                return response()->json([
                    'message' => 'Erreur lors de la création du contact',
                ], 500);
            }

            $user = User::create(array_merge(
                $request->except('password'),
                [
                    'password' => bcrypt($request->password),
                    'id_contact' => $contact->id
                ]
            ));

            return response()->json([
                'message' => 'Utilisateur créé avec succès.',
                'data' => $user
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de la création de l\'utilisateur',
                'errors' => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'login' => "nullable|unique:users,login,$id",
                'idCOD' => 'nullable|unique:users,idCOD',
                'id_role' => 'nullable|exists:roles,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erreur de validation des champs',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'message' => 'Utilisateur introuvable',
                ], 404);
            }

            $user->contact->update($request->only(
                'telephone',
                'adress',
                'email',
                'whatsapp',
            ));

            $user->update(array_merge(
                $request->except('password'),
                [
                    'password' => $request->has('password') ? bcrypt($request->password) : $user->password
                ]
            ));

            return response()->json($user->load('contact', 'role', 'boutiques'), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de la mise à jour de l\'utilisateur',
                'errors' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'message' => 'Utilisateur introuvable',
                ], 404);
            }

            $contactId = $user->id_contact;

            $user->delete();

            $contact = Contact::find($contactId);
            if ($contact) {
                $contact->delete();
            }

            return response()->json([
                'message' => 'Utilisateur supprimé avec succès',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de la suppresion de l\'utilisateur',
                'errors' => $th->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'login' => 'required',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erreur de validation des champs',
                    'errors' => $validator->errors(),
                ], 422);
            }
            $user = User::where('login', $request->login)->first();

            if (!$user || !password_verify($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Identifiants incorrectes',
                ], 401);
            }

            return $user->load('contact', 'role', 'boutiques');
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de la connexion',
                'errors' => $th->getMessage(),
            ], 500);
        }
    }

     public function me()
    {
        try {
            $user = Auth::user()->load('role', 'contact');

            return response()->json([
                'message' => 'Profil utilisateur récupéré avec succès.',
                'data' => $user,
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération du profil.',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
