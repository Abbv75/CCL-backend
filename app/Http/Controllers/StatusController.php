<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatusController extends Controller
{
    public function index()
    {
        try {
            $statuses = Status::all();

            if (!$statuses) {
                return response()->json([
                    'message' => 'Aucun statut trouvé.'
                ], 404);
            }

            return response()->json([
                'message' => 'Liste des statuts récupérée avec succès.',
                'data' => $statuses
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des statuts.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $status = Status::find($id);

            if (!$status) {
                return response()->json([
                    'message' => 'Aucun statut trouvé.'
                ], 404);
            }

            return response()->json([
                'message' => 'Statut récupéré avec succès.',
                'data' => $status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération du statut.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|string|max:10|unique:statuses,id',
                'nom' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Champs invalides.',
                    'error' => $validator->errors()
                ], 422);
            }

            $status = Status::create($request->all());

            return response()->json([
                'message' => 'Statut créé avec succès.',
                'data' => $status
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création du statut.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $status = Status::find($id);

            if (!$status) {
                return response()->json([
                    'message' => 'Aucun statut trouvé.'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'nom' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Champs invalides.',
                    'error' => $validator->errors()
                ], 422);
            }

            $status->update($request->all());

            return response()->json([
                'message' => 'Statut mis à jour avec succès.',
                'data' => $status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la mise à jour du statut.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $status = Status::find($id);

            if (!$status) {
                return response()->json([
                    'message' => 'Aucun statut trouvé.'
                ], 404);
            }

            $status->delete();

            return response()->json([
                'message' => 'Statut supprimé avec succès.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la suppression du statut.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
