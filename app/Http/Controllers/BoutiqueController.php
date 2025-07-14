<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Contact;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BoutiqueController extends Controller
{
    public function index()
    {
        try {
            $boutiques = Boutique::with(['contact', 'typeAbonnement', 'proprietaire'])->get();

            return $boutiques;
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la récupération des boutiques',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $boutique = Boutique::with('contact')->find($id);
            if (!$boutique) {
                return response()->json([
                    'message' => 'Boutique non trouvée'
                ], 404);
            }

            return $boutique;
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la récupération de la boutique',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Aplatir les données pour la validation
            $data = [
                'boutique_nom' => $request->input('boutique.nom'),
                'boutique_image' => $request->file('boutique.image'),
                'boutique_isPartenaire' => $request->boolean('boutique.isPartenaire'),
                'boutique_nbrMoisAbonnement' => $request->input('boutique.nbrMoisAbonnement'),
                'boutique_typeAbonnement' => $request->input('boutique.typeAbonnement'),
                'boutique_pourcentageProduit' => $request->input('boutique.pourcentageProduit'),
                'boutique_telephone' => $request->input('boutique.telephone'),
                'boutique_email' => $request->input('boutique.email'),
                'boutique_address' => $request->input('boutique.address'),
                'boutique_whatsapp' => $request->input('boutique.whatsapp'),

                'user_nomComplet' => $request->input('user.nomComplet'),
                'user_login' => $request->input('user.login'),
                'user_password' => $request->input('user.password'),
                'user_telephone' => $request->input('user.telephone'),
                'user_email' => $request->input('user.email'),
                'user_address' => $request->input('user.address'),
                'user_whatsapp' => $request->input('user.whatsapp'),

                'id_user' => $request->input('id_user'),
            ];

            $validator = Validator::make($data, [
                'boutique_nom' => 'required|unique:boutiques,nom',
                'boutique_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                'boutique_nbrMoisAbonnement' => 'nullable|integer',
                'boutique_isPartenaire' => 'required|boolean',
                'boutique_typeAbonnement' => 'nullable|exists:type_abonnements,id',
                'boutique_pourcentageProduit' => 'nullable',
                'boutique_telephone' => 'required',
                'boutique_email' => 'nullable|email',
                'boutique_address' => 'nullable|string',
                'boutique_whatsapp' => 'nullable|string',

                'user_nomComplet' => 'nullable|string',
                'user_login' => 'nullable|unique:users,login',
                'user_password' => 'nullable|string|min:8',
                'user_telephone' => 'nullable|string',
                'user_email' => 'nullable|email',
                'user_address' => 'nullable|string',
                'user_whatsapp' => 'nullable|string',

                'id_user' => 'nullable|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation échouée',
                    'errors' => $validator->errors()
                ], 422);
            }

            if (!$request->has('user') && !$request->filled('id_user')) {
                return response()->json([
                    'message' => 'Validation échouée. Veuillez fournir les informations de l\'utilisateur ou l\'ID d\'un utilisateur existant.',
                ], 422);
            }

            if ($request->boolean('boutique.isPartenaire')) {
                if (!$request->filled('boutique.pourcentageProduit')) {
                    return response()->json([
                        'message' => "Validation échouée. Cette boutique est un partenaire et aucun pourcentage n'a été fixé.",
                    ], 422);
                }
            }

            // Création du contact boutique
            $contact = Contact::create($request->input('boutique'));

            // Gestion de l'image
            $imageName = null;
            if ($request->hasFile('boutique.image')) {
                $image = $request->file('boutique.image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/boutique/image'), $imageName);
            }

            // Création de la boutique
            $boutique = Boutique::create(array_merge(
                $request->input('boutique'),
                [
                    'image' => $imageName,
                    'id_contact' => $contact->id,
                    'isPartenaire' => $request->boolean('boutique.isPartenaire'),
                    'pourcentageProduit' => $request->boolean('boutique.isPartenaire') ? $request->input('boutique.pourcentageProduit') : null,
                    'id_type_abonnement' => $request->boolean('boutique.isPartenaire') ? null : $request->input('boutique.typeAbonnement'),
                    'debutAbonnement' => $request->boolean('boutique.isPartenaire') ? null : now(),
                    'finAbonnement' => $request->boolean('boutique.isPartenaire') ? null : now()->addMonths($request->input('boutique.nbrMoisAbonnement', 1)),
                ]
            ));

            // Gestion de l'utilisateur
            if ($request->filled('id_user')) {
                $id_user = $request->input('id_user');
            } else {
                $contactUser = Contact::create($request->input('user'));

                $user = User::create(array_merge(
                    $request->input('user'),
                    [
                        'id_contact' => $contactUser->id,
                        'id_role' => 2,
                        'password' => bcrypt($request->input('user.password')),
                    ]
                ));

                $id_user = $user->id;
            }

            // Création du lien boutique-employé
            Employer::create([
                'id_user' => $id_user,
                'id_boutique' => $boutique->id,
            ]);

            $boutique->load('contact');

            return response()->json($boutique, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la création de la boutique',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nom' => 'nullable|unique:boutiques,nom,' . $id,
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                'pourcentageProduit' => 'nullable|numeric',
                'debutAbonnement' => 'nullable|date',
                'finAbonnement' => 'nullable|date',
                'email' => 'nullable|email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation échouée',
                    'errors' => $validator->errors()
                ], 422);
            }

            $boutique = Boutique::find($id);
            if (!$boutique) {
                return response()->json([
                    'message' => 'Boutique non trouvée'
                ], 404);
            }

            $contact = Contact::find($boutique->id_contact);
            if (!$contact) {
                $contact = Contact::create($request->only([
                    'telephone',
                    'email',
                    'address',
                    'whatsapp',
                ]));
            } else {
                $contact->update($request->only([
                    'telephone',
                    'email',
                    'address',
                    'whatsapp',
                ]));
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/boutique/image'), $image_name);

                $image = $image_name;
            }

            if ($boutique->isPartenaire) {
                $request->merge([
                    'debutAbonnement' => null,
                    'finAbonnement' => null,
                ]);
            } else {
                $request->merge([
                    'pourcentageProduit' => null,
                ]);
            }

            $boutique->update(array_merge(
                $request->except(
                    'image',
                    'isPartenaire',
                ),
                [
                    'image' => $image ?? $boutique->image,
                    'id_contact' => $contact->id,
                ]
            ));

            return $boutique->load('contact');
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la mise à jour de la boutique',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $boutique = Boutique::find($id);
            if (!$boutique) {
                return response()->json([
                    'message' => 'Boutique non trouvée'
                ], 404);
            }

            $boutique->delete();

            $contact = Contact::find($boutique->id_contact);
            if ($contact) {
                $contact->delete();
            }

            return response()->json([
                'message' => 'Boutique supprimée avec succès'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la suppression de la boutique',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function rennouvellerAbonnement(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nbrMoisAbonnement' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation des champs échouée',
                    'errors' => $validator->errors()
                ], 422);
            }

            $boutique = Boutique::find($id);
            if (!$boutique) {
                return response()->json([
                    'message' => 'Boutique non trouvée'
                ], 404);
            }

            $boutique->update([
                'debutAbonnement' => now(),
                'finAbonnement' => (
                    isset($boutique->finAbonnement) && $boutique->finAbonnement > now()
                    ? $boutique->finAbonnement->addMonths($request->nbrMoisAbonnement)
                    : now()->addMonths($request->nbrMoisAbonnement)
                ),
            ]);

            return $boutique->load('contact');
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Une erreur est survenue lors du renouvellement de l'abonnement de la boutique",
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function resilierAbonnement($id)
    {
        try {
            $boutique = Boutique::find($id);
            if (!$boutique) {
                return response()->json([
                    'message' => 'Boutique non trouvée'
                ], 404);
            }

            $boutique->update([
                'debutAbonnement' => null,
                'finAbonnement' => null,
            ]);

            return $boutique->load('contact');
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Une erreur est survenue lors de la résiliation de l'abonnement de la boutique",
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function getImage($image)
    {
        try {
            $path = public_path('images/boutique/image/' . $image);
            if (!file_exists($path)) {
                return response()->json(['message' => 'Image non trouvée'], 404);
            }
            return response()->file($path);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la récupération de l\'image',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function getProprietaire($id)
    {
        try {
            // get the user from employer where id_boutique = $id and id_role = 2
            $user = User::whereHas('employer', function ($query) use ($id) {
                $query->where('id_boutique', $id);
            })->where('id_role', 2)->first();
            if (!$user) {
                return response()->json([
                    'message' => 'Aucun propriétaire trouvé pour cette boutique'
                ], 404);
            }

            return $user->load('contact', 'role');
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la récupération du propriétaire',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
