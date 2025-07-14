<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contact;
use App\Models\Produit;
use App\Models\Vente;
use App\Models\VenteProduit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VenteController extends Controller
{
    public function index(Request $request)
    {
        try {
            $boutique = $request->attributes->get('currentBoutique');

            return $boutique->ventes()->with(['client'])->get();
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getMessage(),
                'message' => 'Une erreur est survenue lors de la recuperation des ventes'
            ], 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $boutique = $request->attributes->get('currentBoutique');
            $vente = $boutique->ventes()
                ->with(['client', 'venteProduits.produit'])
                ->where('id', $id)
                ->first();

            if (!$vente) {
                return response()->json([
                    'message' => 'Vente non trouvée'
                ], 404);
            }

            return $vente;
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getMessage(),
                'message' => 'Une erreur est survenue lors de la recuperation de la vente'
            ], 500);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client' => 'required|array',
            'client.nomComplet' => 'required|string|max:255',
            'client.telephone' => 'required|string|max:20',
            'client.email' => 'nullable|email',
            'client.adresse' => 'nullable|string',
            'client.whatsapp' => 'nullable|string',
            'produitsList' => 'required|array|min:1',
            'produitsList.*.id' => 'required|integer|exists:produits,id',
            'produitsList.*.quantite' => 'required|integer|min:1',
            'produitsList.*.montant' => 'nullable|numeric|min:0',
            'is_detail' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erreur de validation des champs',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $vente = DB::transaction(function () use ($request) {
                $boutique = $request->attributes->get("currentBoutique");

                $clientData = $request->input('client');

                $contact = Contact::create([
                    'telephone' => $clientData['telephone'],
                    'email' => $clientData['email'] ?? null,
                    'adresse' => $clientData['adresse'] ?? null,
                    'whatsapp' => $clientData['whatsapp'] ?? null,
                ]);

                $client = Client::create([
                    'nomComplet' => $clientData['nomComplet'],
                    'id_contact' => $contact->id
                ]);

                $vente = Vente::create([
                    'montant' => 0,
                    'id_boutique' => $boutique->id,
                    'id_client' => $client->id
                ]);

                $montantTotalVente = 0;

                foreach ($request->input('produitsList') as $produitData) {
                    $produit = Produit::find($produitData['id']);

                    if ($produit) {
                        $prixUnitaire = $produitData['montant'] ?? ($request->is_detail ? $produit->prixVenteDetails : $produit->prixVenteEngros);
                        $quantite = $produitData['quantite'];

                        $montantLigne = $prixUnitaire * $quantite;
                        $montantTotalVente += $montantLigne;

                        VenteProduit::create([
                            'quantite' => $quantite,
                            'montant' => $prixUnitaire, // On stocke le prix unitaire au moment de la vente
                            'id_produit' => $produit->id,
                            'id_vente' => $vente->id
                        ]);

                        $quantiteFinal = $produit->quantite - $quantite;

                        $produit->update(['quantite' => $quantiteFinal < 0 ? 0 : $quantiteFinal]);
                    }
                }

                $vente->montant = $montantTotalVente;
                $vente->save();

                return $vente;
            });

            return response()->json($vente, 201);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => 'Une erreur est survenue lors de la création de la vente.',
                "error" => $th->getMessage(),
            ], 500);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $boutique = $request->attributes->get("currentBoutique");
            $vente = Vente::find($id)->where('id_boutique', $boutique->id)->first();

            if (!$vente) {
                return response()->json(["message" => "Vente introuvable"], 404);
            }

            $vente->delete();

            return response()->json(["message" => "Vente supprimer avec success"], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => 'Une erreur est survenue lors de la suppresion de la vente.',
                "error" => $th->getMessage(),
            ], 500);
        }
    }
}
