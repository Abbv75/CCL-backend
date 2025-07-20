<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

            $contact = Contact::create(
                array_merge(
                    $request->only(
                        'telephone',
                        'adress',
                        'email',
                        'whatsapp',
                    ),
                    ['id' => Str::uuid()],
                )
            );

            if (!$contact) {
                return response()->json([
                    'message' => 'Erreur lors de la création du contact',
                ], 500);
            }

            $user = User::create(array_merge(
                $request->except('password',),
                [
                    'id' => Str::uuid(),
                    'motDePasse' => bcrypt($request->motDePasse),
                    'id_contact' => $contact->id,
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

    public function me()
    {
        try {
            $id = Auth::id();
            if (!$id) {
                return response()->json([
                    'message' => 'Utilisateur non authentifié.'
                ], 401);
            }

            $user = User::with('role', 'contact')->find($id);

            return response()->json([
                'message' => 'Profil utilisateur récupéré avec succès.',
                'data' => $user
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
