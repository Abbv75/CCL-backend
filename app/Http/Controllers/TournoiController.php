<?php

namespace App\Http\Controllers;

use App\Models\Tournoi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TournoiController extends Controller
{
    public function index()
    {
        try {
            $tournois = Tournoi::with('participants')->get();

            if (!$tournois) {
                return response()->json([
                    'message' => 'Aucun tournoi trouvé',
                ], 404);
            }

            return response()->json([
                'message' => 'Liste des tournois récupérée avec succès.',
                'data' => $tournois
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des tournois.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $tournoi = Tournoi::with('participants')->find($id);

            if (!$tournoi) {
                return response()->json([
                    'message' => 'Tournoi introuvable'
                ], 404);
            }

            return response()->json([
                'message' => 'Tournoi récupéré avec succès.',
                'data' => $tournoi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération du tournoi.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nom' => 'required|string|max:255',
                'date_debut' => 'nullable|date',
                'id_status' => 'required|exists:statuses,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Champs invalides.',
                    'error' => $validator->errors()
                ], 422);
            }

            $tournoi = Tournoi::create(array_merge(
                $request->all(),
                [
                    'id' => Str::uuid()
                ]
            ));

            return response()->json([
                'message' => 'Tournoi créé avec succès.',
                'data' => $tournoi
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création du tournoi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $tournoi = Tournoi::find($id);
            if (!$tournoi) {
                return response()->json([
                    'message' => 'Tournoi introuvable'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'date_debut' => 'nullable|date',
                'id_status' => 'sometimes|required|exists:statuses,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Champs invalides.',
                    'error' => $validator->errors()
                ], 422);
            }

            $tournoi->update($request->all());

            return response()->json([
                'message' => 'Tournoi mis à jour avec succès.',
                'data' => $tournoi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la mise à jour du tournoi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $tournoi = Tournoi::find($id);

            if (!$tournoi) {
                return response()->json([
                    'message' => 'Tournoi introuvable'
                ], 404);
            }

            $tournoi->delete();

            return response()->json([
                'message' => 'Tournoi supprimé avec succès.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la suppression du tournoi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function listParticipants($idTournoi)
    {
        try {
            $tournoi = Tournoi::with('participants')->find($idTournoi);

            if (!$tournoi) {
                return response()->json([
                    'message' => 'Tournoi introuvable'
                ], 404);
            }

            return response()->json([
                'message' => 'Erreur lors de la récupération des participants',
                'data' => $tournoi->participants
            ], 500);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des participants',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function addParticipants(Request $request, $idTournoi)
    {
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

        try {
            $tournoi = Tournoi::find($idTournoi);

            if (!$tournoi) {
                return response()->json([
                    'message' => 'Tournoi introuvable'
                ], 404);
            }

            $tournoi->participants()->syncWithoutDetaching($request->participants);

            return response()->json([
                'message' => 'Participants ajoutés avec succès',
                'data' => $tournoi->load('participants')
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de l\'ajout des participants',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function removeParticipants(Request $request, $idTournoi)
    {
        try {
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

            $tournoi = Tournoi::find($idTournoi);

            if (!$tournoi) {
                return response()->json([
                    'message' => 'Tournoi introuvable'
                ], 404);
            }

            $tournoi->participants()->detach($request->participants);

            return response()->json([
                'message' => 'Participants supprimés avec succès',
                'data' => $tournoi->load('participants')
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de la suppression des participants',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
