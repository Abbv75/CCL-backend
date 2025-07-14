<?php

namespace App\Http\Controllers;

use App\Models\TypeAbonnement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeAbonnementController extends Controller
{
    public function index()
    {
        return TypeAbonnement::all();
    }

    public function show($id)
    {
        $typeAbonnement = TypeAbonnement::find($id);
        if (!$typeAbonnement) {
            return response()->json(['message' => 'Type d\'abonnement non trouvé'], 404);
        }

        return $typeAbonnement;
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nom' => 'required|string',
                'description' => 'nullable|string',
                'prix' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation échouée',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $typeAbonnement = TypeAbonnement::create($request->all());
            return response()->json($typeAbonnement, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de la création du type d\'abonnement',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'prix' => 'nullable|numeric',
                'nom' => 'nullable|unique:type_abonnements,nom,' . $id,
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation échouée',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $typeAbonnement = TypeAbonnement::find($id);
            if (!$typeAbonnement) {
                return response()->json(['message' => 'Type d\'abonnement non trouvé'], 404);
            }

            $typeAbonnement->update($request->all());
            return response()->json($typeAbonnement);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de la mise à jour du type d\'abonnement',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $typeAbonnement = TypeAbonnement::find($id);
            if (!$typeAbonnement) {
                return response()->json(['message' => 'Type d\'abonnement non trouvé'], 404);
            }

            $typeAbonnement->delete();
            return response()->json(['message' => 'Type d\'abonnement supprimé avec succès']);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de la suppression du type d\'abonnement',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
