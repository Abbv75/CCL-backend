<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategorieController extends Controller
{
    public function index(Request $request)
    {
        try {
            $boutique = $request->attributes->get('currentBoutique');

            return Categorie::where('id_boutique', $boutique->id)->get();
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getMessage(),
                'message' => 'Une erreur est survenue lors de la recuperation des categories'
            ], 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $currentBoutique = $request->attributes->get('currentBoutique');

            $validator = Validator::make($request->all(), [
                'nom' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erreur de validation des champs',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = Categorie::create(array_merge(
                $request->all(),
                [
                    'id_boutique' => $currentBoutique->id
                ]
            ));

            return response()->json($data, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'message' => 'Une erreur est survenue lors de l\'ajout de la categorie'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $categorie = Categorie::find($id);
            if (! $categorie) {
                return response()->json(['message' => 'Categorie introuvable', 404]);
            }

            $categorie->update($request->only('nom', 'description'));

            return $categorie;
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'message' => 'Une erreur est survenue lors de l\'ajout de la categorie'
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            Categorie::find($id)->delete();

            return ['message' => 'Categorie supprimée avec succès'];
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'message' => 'Une erreur est survenue lors de la suppression de la categorie'
            ], 500);
        }
    }
}
