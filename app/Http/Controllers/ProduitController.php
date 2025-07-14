<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\ProduitImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProduitController extends Controller
{
    public function index()
    {
        try {
            $boutique = request()->attributes->get('currentBoutique');
            return Produit::with('images', 'categorie')
                ->where('id_boutique', $boutique->id)
                ->get();
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getMessage(),
                'message' => 'Une erreur est survenue lors de la recuperation des produits'
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $produit = Produit::with('images', 'categorie')
                ->where('id', $id)
                ->first();
            if (!$produit) {
                return response()->json([
                    'message' => 'Produit non trouvé'
                ], 404);
            }
            return $produit;
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getMessage(),
                'message' => 'Une erreur est survenue lors de la recuperation du produit'
            ], 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $currentBoutique = $request->attributes->get('currentBoutique');

            $validator = Validator::make($request->all(), [
                'nom' => 'required',
                'prixAchat' => 'required|numeric|min:0',
                'prixVenteDetails' => 'required|numeric|min:0',
                'prixVenteEngros' => 'required|numeric|min:0',
                'quantite' => 'nullable|numeric|min:0',
                'id_categorie' => 'required|exists:categories,id',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erreur de validation des champs',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $produit = Produit::create(array_merge(
                $request->all(),
                ['id_boutique' => $currentBoutique->id]
            ));

            if (isset($request->images)) {
                foreach ($request->images as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('images/produit/image'), $imageName);

                    $produit->images()->create([
                        'file' => $imageName,
                    ]);
                }
            }

            return response()->json($produit, 201);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getMessage(),
                'message' => 'Une erreur est survenue lors de la creation du produit'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $currentBoutique = $request->attributes->get('currentBoutique');

            $produit = Produit::where('id', $id)
                ->where('id_boutique', $currentBoutique->id)
                ->first();

            if (!$produit) {
                return response()->json([
                    'message' => 'Produit non trouvé'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'prixAchat' => 'nullable|numeric|min:0',
                'prixVenteDetails' => 'nullable|numeric|min:0',
                'prixVenteEngros' => 'nullable|numeric|min:0',
                'quantite' => 'nullable|numeric|min:0',
                'id_categorie' => 'nullable|exists:categories,id',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erreur de validation des champs',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $produit->update($request->all());

            return response()->json($produit, 200);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getMessage(),
                'message' => 'Une erreur est survenue lors de la mise à jour du produit'
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $currentBoutique = $request->attributes->get('currentBoutique');

            $produit = Produit::where('id', $id)
                ->where('id_boutique', $currentBoutique->id)
                ->first();

            if (!$produit) {
                return response()->json([
                    'message' => 'Produit non trouvé'
                ], 404);
            }

            $produit->delete();

            return response()->json(['message' => 'Produit supprimé avec succès'], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getMessage(),
                'message' => 'Une erreur est survenue lors de la suppression du produit'
            ], 500);
        }
    }

    public function getImage($name)
    {
        try {
            $path = public_path('images/produit/image/' . $name);
            if (!file_exists($path)) {
                return response()->json(['message' => 'Image non trouvée'], 404);
            }
            return response()->file($path);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getMessage(),
                'message' => 'Une erreur est survenue lors de la recuperation de l\'image'
            ], 500);
        }
    }

    public function deleteImage(Request $request, $id)
    {
        try {
            $currentBoutique = $request->attributes->get('currentBoutique');

            $produit = Produit::where('id', $id)
                ->where('id_boutique', $currentBoutique->id)
                ->first();
            if (!$produit) {
                return response()->json([
                    'message' => 'Produit non trouvé'
                ], 404);
            }
            $validator = Validator::make($request->all(), [
                'id_image' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erreur de validation des champs',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $image = ProduitImage::find($request->id_image);
            if (!$image) {
                return response()->json([
                    'message' => 'Image non trouvée'
                ], 404);
            }
            if ($image) {
                $image->delete();
            }

            return response()->json(['message' => 'Image supprimée avec succès'], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getMessage(),
                'message' => 'Une erreur est survenue lors de la suppression de l\'image'
            ], 500);
        }
    }

    public function addImage(Request $request, $id)
    {
        try {
            $currentBoutique = $request->attributes->get('currentBoutique');

            $produit = Produit::where('id', $id)
                ->where('id_boutique', $currentBoutique->id)
                ->first();

            if (!$produit) {
                return response()->json([
                    'message' => 'Produit non trouvé'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'image' => 'required|array',
                'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erreur de validation des champs',
                    'errors' => $validator->errors(),
                ], 422);
            }

            foreach ($request->image as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/produit/image'), $imageName);

                $produit->images()->create([
                    'file' => $imageName,
                ]);
            }

            return response()->json(['message' => 'Image ajoutée avec succès'], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getMessage(),
                'message' => 'Une erreur est survenue lors de l\'ajout de l\'image'
            ], 500);
        }
    }
}
