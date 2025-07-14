<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Contact;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployerController extends Controller
{
    public function index(Request $request)
    {
        try {
            $boutique = $request->attributes->get('currentBoutique');

            $user = $boutique->load('employers');
            return $user['employers'];
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la récupération des boutiques',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nomComplet' => 'required',
                'login' => 'required|unique:users',
                'password' => 'required|string|min:8',
                'id_role' => 'required|exists:roles,id',
                'telephone' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erreur de validation des champs',
                    'errors' => $validator->errors(),
                ], 422);
            }

            if (!in_array($request->id_role, [4, 5])) {
                return response()->json(['message' => 'Role non autorisé'], 422);
            }

            $contact = Contact::create($request->all());

            if (!$contact) {
                return response()->json([
                    'message' => 'Erreur lors de la création du contact',
                ], 500);
            }

            $request->merge(['id_contact' => $contact->id]);
            $request->merge(['password' => bcrypt($request->password)]);

            $user = User::create($request->all());

            $boutique = $request->attributes->get('currentBoutique');

            Employer::create([
                'id_user' => $user->id,
                'id_boutique' => $boutique->id,
            ]);

            return response()->json($user->load('contact', 'role'), 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de la création de l\'employer',
                'errors' => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'login' => 'nullable|unique:users,' . $id,
                'password' => 'nullable|string|min:8',
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
                return response()->json(['message' => 'utilisateur introuvable'], 404);
            }

            if ($request->id_role) {
                if (!in_array($request->id_role, [4, 5])) {
                    return response()->json(['message' => 'Role non autorisé'], 422);
                }
            }

            $user->contact->update($request->all());

            if ($request->password) {
                $request->merge(['password' => bcrypt($request->password)]);
            }

            $user->update($request->all());

            return $user->load('contact', 'role');
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de la modification de l\'employer',
                'errors' => $th->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['message' => 'utilisateur introuvable'], 404);
            }

            $user->delete();
            $user->contact->delete();

            return ['message' => 'Employer supprimé'];
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de la supprimer de l\'employer',
                'errors' => $th->getMessage(),
            ], 500);
        }
    }
}
