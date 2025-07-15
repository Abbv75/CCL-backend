<?php

namespace App\Http\Controllers;

use App\Models\Partie;
use App\Models\Tournoi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class PartieController extends Controller
{
    public function index($tournoi_id)
    {
        try {
            $tournoi = Tournoi::find($tournoi_id);
            if (!$tournoi) {
                return response()->json([
                    'message' => 'Tournoi non trouvé.',
                ], 404);
            }

            $parties = Partie::with(['status', 'participants', 'gagnant'])
                ->where('id_tournoi', $tournoi_id)
                ->get();

            if (empty($parties)) {
                return response()->json([
                    'message' => 'Aucune partie trouvée.',
                ], 404);
            }

            return response()->json([
                'message' => 'Liste des parties du tournoi récupérée avec succès.',
                'data' => $parties
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des parties.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($tournoi_id, $id)
    {
        try {
            $tournoi = Tournoi::find($tournoi_id);

            if (!$tournoi) {
                return response()->json([
                    'message' => 'Tournoi non trouvé.',
                ], 404);
            }

            $partie = Partie::with(['status', 'participants', 'gagnant'])
                ->where('id_tournoi', $tournoi_id)
                ->find($id);

            if (!$partie) {
                return response()->json([
                    'message' => 'Partie non trouvée.',
                ], 404);
            }

            return response()->json([
                'message' => 'Partie récupérée avec succès.',
                'data' => $partie
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération de la partie.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function store(Request $request, $tournoi_id)
    {
        try {
            $tournoi = Tournoi::find($tournoi_id);

            if (!$tournoi) {
                return response()->json([
                    'message' => 'Tournoi non trouvé.',
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'date_heure' => 'nullable|date',
                'id_status' => 'required|exists:statuses,id',
                'id_gagnant' => 'nullable|exists:users,id',
                'participants' => 'nullable|array',
                'participants.*' => 'exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Champs invalides.',
                    'error' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();

            $partie = Partie::create(array_merge(
                $request->all(),
                ['id_tournoi' => $tournoi_id]
            ));

            if (!empty($validated['participants'])) {
                $partie->participants()->sync($validated['participants']);
            }

            return response()->json([
                'message' => 'Partie créée avec succès.',
                'data' => $partie->load('participants')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création de la partie.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
