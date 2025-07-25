<?php

namespace App\Http\Controllers;

use App\Models\Partie;
use App\Models\PartieUser;
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
                'data' => $partie->load('status', 'participants', 'gagnant')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création de la partie.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $tournoi_id, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date_heure' => 'nullable|date',
                'id_status' => 'sometimes|required|exists:statuses,id',
                'id_gagnant' => 'nullable|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Champs invalides.',
                    'error' => $validator->errors()
                ], 422);
            }

            $tournoi = Tournoi::find($tournoi_id);

            if (!$tournoi) {
                return response()->json([
                    'message' => 'Tournoi non trouvé.',
                ], 404);
            }

            $partie = Partie::where('id_tournoi', $tournoi_id)->find($id);

            if (!$partie) {
                return response()->json([
                    'message' => 'Tournoi non trouvé.',
                ], 404);
            }

            $partie->update($validator->validated());

            return response()->json([
                'message' => 'Partie mise à jour avec succès.',
                'data' => $partie->load('status', 'participants', 'gagnant')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la mise à jour de la partie.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($tournoi_id, $id)
    {
        try {
            $tournoi = Tournoi::find($tournoi_id);

            if (!$tournoi) {
                return response()->json([
                    'message' => 'Tournoi non trouvé.',
                ], 404);
            }

            $partie = Partie::where('id_tournoi', $tournoi_id)->find($id);

            if (!$partie) {
                return response()->json([
                    'message' => 'Tournoi non trouvé.',
                ], 404);
            }

            $partie->delete();

            return response()->json([
                'message' => 'Partie supprimée avec succès.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la suppression de la partie.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function addParticipants(Request $request, $tournoi_id, $partie_id)
    {
        try {
            $partie = Partie::where('id_tournoi', $tournoi_id)->find($partie_id);

            if (!$partie) {
                return response()->json([
                    'message' => 'Partie non trouvé.',
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'participants' => 'required|array|min:1',
                'participants.*' => 'exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Champs invalides pour les participants.',
                    'error' => $validator->errors()
                ], 422);
            }

            PartieUser::insert(
                array_map(function ($participantId) use ($partie_id) {
                    return [
                        'id' => Str::uuid(),
                        'id_partie' => $partie_id,
                        'id_user' => $participantId
                    ];
                }, $request->participants)
            );

            return response()->json([
                'message' => 'Participants ajoutés avec succès.',
                'data' => $partie->load('status', 'participants', 'gagnant')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de l\'ajout des participants.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function removeParticipants(Request $request, $tournoi_id, $partie_id)
    {
        try {
            $partie = Partie::where('id_tournoi', $tournoi_id)->findOrFail($partie_id);

            $validator = Validator::make($request->all(), [
                'participants' => 'required|array|min:1',
                'participants.*' => 'exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Champs invalides pour les participants.',
                    'error' => $validator->errors()
                ], 422);
            }

            $partie->participants()->detach($request->participants);

            return response()->json([
                'message' => 'Participants supprimés avec succès.',
                'data' => $partie->load('status', 'participants', 'gagnant')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la suppression des participants.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
