<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    /**
     * @OA\Schema(
     *     schema="Role",
     *     type="object",
     *     title="Role",
     *     description="Role model",
     *     required={"id", "nom", "description"},
     *     @OA\Property(property="id", type="integer"),
     *     @OA\Property(property="nom", type="string"),
     *     @OA\Property(property="description", type="string"),
     * )
     * 
     * @OA\Schema(
     *     schema="User",
     *     type="object",
     *     title="User",
     *     description="User model",
     *     required={"id", "nomComplet", "login", "password", "telephone", "id_role"},
     *     @OA\Property(property="id", type="integer"),
     *     @OA\Property(property="nomComplet", type="string"),
     *     @OA\Property(property="login", type="string"),
     *     @OA\Property(property="password", type="string"),
     *     @OA\Property(property="telephone", type="string"),
     *     @OA\Property(property="adress", type="string"),
     *     @OA\Property(property="email", type="string"),
     *     @OA\Property(property="whatsapp", type="string"),
     *     @OA\Property(property="id_role", type="integer"),
     *     @OA\Property(property="role", ref="#/components/schemas/Role"),
     *     @OA\Property(property="contact", ref="#/components/schemas/Contact"),
     * )
     * 
     * @OA\Schema(
     *     schema="Contact",
     *     type="object",
     *     title="Contact",
     *     description="Contact model",
     *     required={"id", "telephone"},
     *     @OA\Property(property="id", type="integer"),
     *     @OA\Property(property="telephone", type="string"),
     *     @OA\Property(property="email", type="string"),
     *     @OA\Property(property="whatsapp", type="string"),
     *     @OA\Property(property="address", type="string"),
     * )
     * 
     * @OA\Schema(
     *     schema="TypeAbonnement",
     *     type="object",
     *     title="TypeAbonnement",
     *     description="TypeAbonnement model",
     *     required={"id", "nom", "prix"},
     *     @OA\Property(property="id", type="integer"),
     *     @OA\Property(property="nom", type="string"),
     *     @OA\Property(property="description", type="string"),
     *     @OA\Property(property="prix", type="number", format="float"),
     * )
     * 
     * @OA\Schema(
     *      schema="Boutique",
     *      type="object",
     *      title="Boutique",
     *      description="Boutique model",
     *      required={"id", "nom", "isPartenaire", "id_contact", "id_type_abonnement", "contact", "proprietaire"},
     *      @OA\Property(property="id", type="integer"),
     *      @OA\Property(property="nom", type="string"),
     *      @OA\Property(property="image", type="string"),
     *      @OA\Property(property="debutAbonnement", type="string", format="date-time"),
     *      @OA\Property(property="finAbonnement", type="string", format="date-time"),
     *      @OA\Property(property="isPartenaire", type="boolean"),
     *      @OA\Property(property="pourcentageProduit", type="number", format="float"),
     *      @OA\Property(property="id_contact", type="integer"),
     *      @OA\Property(property="id_type_abonnement", type="integer"),
     *      @OA\Property(property="contact", ref="#/components/schemas/Contact"),
     *      @OA\Property(property="type_abonnement", ref="#/components/schemas/TypeAbonnement"),
     *      @OA\Property(property="proprietaire", ref="#/components/schemas/User"),
     * )
     * 
     * @OA\Schema(
     *     schema="Categorie",
     *     type="object",
     *     title="Categorie",
     *     description="Categorie model",
     *     required={"id", "nom", "id_boutique"},
     *     @OA\Property(property="id", type="integer"),
     *     @OA\Property(property="nom", type="string"),
     *     @OA\Property(property="description", type="string"),
     *     @OA\Property(property="id_boutique", type="integer"),
     * )
     * 
     * @OA\Schema(
     *    schema="Produit",
     *    type="object",
     *    title="Produit",
     *    description="Produit model",
     *    required={"id", "nom", "prixAchat", "prixVenteDetails", "prixVenteEngros", "quantite", "id_boutique"},
     *    @OA\Property(property="id", type="integer"),
     *    @OA\Property(property="nom", type="string"),
     *    @OA\Property(property="prixAchat", type="number", format="float"),
     *    @OA\Property(property="prixVenteDetails", type="number", format="float"),
     *    @OA\Property(property="prixVenteEngros", type="number", format="float"),
     *    @OA\Property(property="quantite", type="integer"),
     *    @OA\Property(property="id_boutique", type="integer"),
     *    @OA\Property(property="id_categorie", type="integer"),
     *    @OA\Property(property="images", type="array", @OA\Items(ref="#/components/schemas/ProduitImage")),
     *    @OA\Property(property="categorie", ref="#/components/schemas/Categorie"),
     * )
     * 
     * @OA\Schema(
     *    schema="ProduitImage",
     *    type="object",
     *    title="ProduitImage",
     *    description="ProduitImage model",
     *    required={"id", "image", "id_produit"},
     *    @OA\Property(property="id", type="integer"),
     *    @OA\Property(property="image", type="string"),
     *    @OA\Property(property="id_produit", type="integer"),
     * )
     * 
     * @OA\Schema(
     *    schema="Client",
     *    type="object",
     *    title="Client",
     *    description="Client model",
     *    required={"id", "nomComplet", "id_contact"},
     *    @OA\Property(property="id", type="integer"),
     *    @OA\Property(property="nomComplet", type="string"),
     *    @OA\Property(property="id_contact", type="integer"),
     *    @OA\Property(property="contact", ref="#/components/schemas/Contact"),
     * )
     * 
     * @OA\Schema(
     *    schema="VenteProduit",
     *    type="object",
     *    title="VenteProduit",
     *    description="VenteProduit model",
     *    required={"id", "id_vente", "id_produit", "quantite", "montant"},
     *    @OA\Property(property="id", type="integer"),
     *    @OA\Property(property="id_vente", type="integer"),
     *    @OA\Property(property="id_produit", type="integer"),
     *    @OA\Property(property="quantite", type="integer"),
     *    @OA\Property(property="montant", type="number", format="float"),
     *    @OA\Property(property="produit", ref="#/components/schemas/Produit"),
     * )
     * 
     * @OA\Schema(
     *    schema="Vente",
     *    type="object",
     *    title="Vente",
     *    description="Vente model",
     *    required={"id", "montant", "id_boutique", "id_client"},
     *    @OA\Property(property="id", type="integer"),
     *    @OA\Property(property="montant", type="number", format="float"),
     *    @OA\Property(property="id_boutique", type="integer"),
     *    @OA\Property(property="id_client", type="integer"),
     *    @OA\Property(property="boutique", ref="#/components/schemas/Boutique"),
     *    @OA\Property(property="client", ref="#/components/schemas/Client"),
     *    @OA\Property(property="venteProduits", type="array", @OA\Items(ref="#/components/schemas/VenteProduit"))
     * )
     */
    public function schema() {}

    /**
     * @OA\Get(
     *     path="/api/roles",
     *     tags={"Roles"},
     *     summary="Get all roles",
     *     description="Get all roles",
     *     operationId="getAllRoles",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Role")
     *         )
     *     ),
     * )
     */
    public function roles() {}

    /** 
     * @OA\Get(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="recupérer tous les utilisateurs",
     *     description="Récupérer tous les utilisateurs avec leur contact et leur rôle",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *            type="array",
     *            @OA\Items(ref="#/components/schemas/User")
     *         )
     *     )
     * )
     * 
     * @OA\Get(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="recupérer un utilisateur",
     *     description="Récupérer un utilisateur avec son contact et son rôle",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     * 
     * @OA\Post(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Créer un utilisateur",
     *     description="Créer un utilisateur avec son contact et son rôle",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"nomComplet", "login", "password", "id_role", "telephone"},
     *                 @OA\Property(property="nomComplet", type="string"),
     *                 @OA\Property(property="login", type="string"),
     *                 @OA\Property(property="password", type="string"),
     *                 @OA\Property(property="id_role", type="integer"),
     *                 @OA\Property(property="telephone", type="string"),
     *                 @OA\Property(property="address", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="whatsapp", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Utilisateur créé avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     *
     * @OA\Put(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Mettre à jour un utilisateur",
     *     description="Mettre à jour un utilisateur avec son contact et son rôle",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="nomComplet", type="string"),
     *                 @OA\Property(property="login", type="string"),
     *                 @OA\Property(property="password", type="string"),
     *                 @OA\Property(property="telephone", type="string"),
     *                 @OA\Property(property="address", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="whatsapp", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur mis à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     *
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Supprimer un utilisateur",
     *     description="Supprimer un utilisateur avec son contact",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur supprimé avec succès"
     *     )
     * )
     *
     * @OA\Post(
     *     path="/api/users/login",
     *     tags={"Users"},
     *     summary="Connexion utilisateur",
     *     description="Connexion d'un utilisateur avec son login et mot de passe",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"login", "password"},
     *                 @OA\Property(property="login", type="string"),
     *                 @OA\Property(property="password", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur connecté avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function users() {}

    /**
     * @OA\Get(
     *     path="/api/type_abonnements",
     *     tags={"TypeAbonnement"},
     *     summary="recuperer tous les types d'abonnements",
     *     description="Recuperer tous les types d'abonnements",
     *     operationId="getTypeAbonnements",
     *     @OA\Response(
     *         response=200,
     *         description="List of type abonnements",
     *         @OA\JsonContent(
     *               type="array",
     *               @OA\Items(ref="#/components/schemas/TypeAbonnement")
     *         )
     *     )
     * )
     *
     * @OA\Get(
     *     path="/api/type_abonnements/{id}",
     *     tags={"TypeAbonnement"},
     *     summary="recuperer un type d'abonnement",
     *     description="Recuperer un type d'abonnement",
     *     operationId="getTypeAbonnementById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du type d'abonnement",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Type abonnement",
     *         @OA\JsonContent(ref="#/components/schemas/TypeAbonnement")
     *     )
     * )
     *
     * @OA\Post(
     *     path="/api/type_abonnements",
     *     tags={"TypeAbonnement"},
     *     summary="Créer un type d'abonnement",
     *     description="Créer un type d'abonnement",
     *     operationId="createTypeAbonnement",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TypeAbonnement")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Type abonnement créé",
     *         @OA\JsonContent(ref="#/components/schemas/TypeAbonnement")
     *     )
     * )
     *
     * @OA\Put(
     *     path="/api/type_abonnements/{id}",
     *     tags={"TypeAbonnement"},
     *     summary="Mettre à jour un type d'abonnement",
     *     description="Mettre à jour un type d'abonnement",
     *     operationId="updateTypeAbonnement",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du type d'abonnement",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TypeAbonnement")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Type abonnement mis à jour",
     *         @OA\JsonContent(ref="#/components/schemas/TypeAbonnement")
     *     )
     * )
     *
     * @OA\Delete(
     *     path="/api/type_abonnements/{id}",
     *     tags={"TypeAbonnement"},
     *     summary="Supprimer un type d'abonnement",
     *     description="Supprimer un type d'abonnement",
     *     operationId="deleteTypeAbonnement",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du type d'abonnement",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Type abonnement supprimé"
     *     )
     * )
     */
    public function typeAbonnement() {}

    /**
     * @OA\Get(
     *     path="/api/boutiques",
     *     tags={"Boutique"},
     *     summary="Recuperer la liste des boutiques",
     *     description="Recuperer la liste des boutiques",
     *     @OA\Response(
     *         response=200,
     *         description="A list of boutiques",
     *         @OA\JsonContent(
     *             type="array",
     *            @OA\Items(ref="#/components/schemas/Boutique")
     *         )
     *     ),
     * )
     *
     * @OA\Get(
     *     path="/api/boutiques/{id}",
     *     tags={"Boutique"},
     *     summary="Recuperer une boutique",
     *     description="Recuperer une boutique",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la boutique",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="La boutique a été récupérée avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Boutique")
     *     ),
     * )
     *
     * @OA\Post(
     *     path="/api/boutiques",
     *     summary="Créer une nouvelle boutique",
     *     description="Créer une boutique avec option de lier un utilisateur existant ou d'en créer un nouveau",
     *     operationId="storeBoutique",
     *     tags={"Boutique"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"boutique"},
     *             @OA\Property(
     *                 property="boutique",
     *                 type="object",
     *                 required={"nom", "isPartenaire", "telephone"},
     *                 @OA\Property(property="nom", type="string", example="Boutique Paris"),
     *                 @OA\Property(property="image", type="string", format="binary"),
     *                 @OA\Property(property="nbrMoisAbonnement", type="integer", example=4),
     *                 @OA\Property(property="isPartenaire", type="boolean", example=true),
     *                 @OA\Property(property="typeAbonnement", type="integer", example=1),
     *                 @OA\Property(property="pourcentageProduit", type="number", format="float", example=15.5),
     *                 @OA\Property(property="telephone", type="string", example="+33612345678"),
     *                 @OA\Property(property="email", type="string", format="email", example="contact@boutique.com"),
     *                 @OA\Property(property="address", type="string", example="123 rue de Paris"),
     *                 @OA\Property(property="whatsapp", type="string", example="+33612345678")
     *             ),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 description="Données utilisateur si création d'un nouvel utilisateur",
     *                 @OA\Property(property="nomComplet", type="string", example="Jean Dupont"),
     *                 @OA\Property(property="login", type="string", example="jeandupont"),
     *                 @OA\Property(property="password", type="string", format="password", example="Motdepasse123"),
     *                 @OA\Property(property="telephone", type="string", example="+33698765432"),
     *                 @OA\Property(property="email", type="string", format="email", example="jean@example.com"),
     *                 @OA\Property(property="address", type="string", example="456 avenue de Lyon"),
     *                 @OA\Property(property="whatsapp", type="string", example="+33698765432")
     *             ),
     *             @OA\Property(
     *                 property="id_user",
     *                 type="integer",
     *                 nullable=true,
     *                 description="ID d'un utilisateur existant si pas de création d'utilisateur",
     *                 example=5
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Boutique créée avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Boutique")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validation échouée"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Une erreur est survenue lors de la création de la boutique"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     *
     * @OA\Post(
     *     path="/api/boutiques/{id}",
     *     tags={"Boutique"},
     *     summary="Mettre à jour une boutique",
     *     description="Mettre à jour une boutique",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la boutique",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom", "telephone"},
     *             @OA\Property(property="nom", type="string", example="Boutique 1"),
     *             @OA\Property(property="image", type="string", format="binary"),
     *             @OA\Property(property="pourcentageProduit", type="number", format="float", example=15.5),
     *             @OA\Property(property="debutAbonnement", type="string", format="date-time", example="2025-04-27T14:00:00Z"),
     *             @OA\Property(property="finAbonnement", type="string", format="date-time", example="2025-10-27T14:00:00Z"),
     *             @OA\Property(property="telephone", type="string", example="+123456789"),
     *             @OA\Property(property="email", type="string", example="bore.younous59@gmail.com"),
     *             @OA\Property(property="address", type="string", example="123 Rue de la Paix"),
     *             @OA\Property(property="whatsapp", type="string", example="+123456789"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="La boutique a été mise à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Boutique")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation échouée",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Boutique non trouvée",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur interne du serveur",
     *     ),
     * )
     *
     * @OA\Delete(
     *     path="/api/boutiques/{id}",
     *     tags={"Boutique"},
     *     summary="Supprimer une boutique",
     *     description="Supprimer une boutique",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la boutique",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="La boutique a été supprimée avec succès",
     *     ),
     * )
     *
     * @OA\Post(
     *     path="/api/boutiques/renouvellerAbonnement/{id}",
     *     tags={"Boutique"},
     *     summary="Renouveler l'abonnement d'une boutique",
     *     description="Renouveler l'abonnement d'une boutique",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la boutique",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nbrMoisAbonnement"},
     *             @OA\Property(property="nbrMoisAbonnement", type="integer", example=6)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="L'abonnement a été renouvelé avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Boutique")
     *     ),
     * )
     *
     * @OA\Post(
     *     path="/api/boutiques/resilierAbonnement/{id}",
     *     tags={"Boutique"},
     *     summary="Annuler l'abonnement d'une boutique",
     *     description="Annuler l'abonnement d'une boutique",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la boutique",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="L'abonnement a été resilier avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Boutique")
     *     ),
     * )
     *
     * @OA\Get(
     *     path="/api/boutiques/image/{image}",
     *     tags={"Boutique"},
     *     summary="Récupérer l'image d'une boutique",
     *     description="Récupérer l'image d'une boutique",
     *     @OA\Parameter(
     *         name="image",
     *         in="path",
     *         required=true,
     *         description="nom de l'image",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="L'image a été récupérée avec succès",
     *         @OA\MediaType(
     *             mediaType="image/jpeg"
     *         )
     *     ),
     * )
     *
     * @OA\Get(
     *     path="/api/boutiques/proprietaire/{id}",
     *     tags={"Boutique"},
     *     summary="Récupérer le propriétaire d'une boutique",
     *     description="Récupérer le propriétaire d'une boutique",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la boutique",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Le propriétaire a été récupéré avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     * )
     */
    public function boutique() {}

    /**
     * @OA\Get(
     *     path="/api/employer",
     *     tags={"Employer"},
     *     summary="les employers d'une boutiques",
     *     description="Recuperer les employers d'une boutiques",
     *     @OA\Parameter(
     *         name="currentboutique",
     *         in="header",
     *         required=true,
     *         description="ID ou code de la boutique courante",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Les employers ont été récupérée avec succès",
     *         @OA\JsonContent(
     *            type="array",
     *            @OA\Items(ref="#/components/schemas/User")
     *         )
     *     ),
     * )
     * 
     * @OA\Post(
     *     path="/api/employer",
     *     tags={"Employer"},
     *     summary="Créer un employer",
     *     description="Créer un employer avec son contact et son rôle en fonction d'une boutique",
     *     @OA\Parameter(
     *         name="currentboutique",
     *         in="header",
     *         required=true,
     *         description="ID ou code de la boutique courante",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"nomComplet", "login", "password", "id_role", "telephone"},
     *                 @OA\Property(property="nomComplet", type="string"),
     *                 @OA\Property(property="login", type="string"),
     *                 @OA\Property(property="password", type="string"),
     *                 @OA\Property(property="id_role", type="integer"),
     *                 @OA\Property(property="telephone", type="string"),
     *                 @OA\Property(property="address", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="whatsapp", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Employer créé avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     * 
     * @OA\Put(
     *     path="/api/employer/{id}",
     *     tags={"Employer"},
     *     summary="Modifier un employer",
     *     description="Modifier un employer avec son contact et son rôle en fonction d'une boutique",
     *     @OA\Parameter(
     *         name="currentboutique",
     *         in="header",
     *         required=true,
     *         description="ID de la boutique courante",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'employer'",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="nomComplet", type="string"),
     *                 @OA\Property(property="login", type="string"),
     *                 @OA\Property(property="password", type="string"),
     *                 @OA\Property(property="id_role", type="integer"),
     *                 @OA\Property(property="telephone", type="string"),
     *                 @OA\Property(property="address", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="whatsapp", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Employer Modifier avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     * 
     * @OA\Delete(
     *     path="/api/employer/{id}",
     *     tags={"Employer"},
     *     summary="Supprimer un employer",
     *     description="Supprimer un employer avec son contact",
     *     @OA\Parameter(
     *         name="currentboutique",
     *         in="header",
     *         required=true,
     *         description="ID de la boutique courante",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'employer'",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Employer Supprimer avec succès",
     *     )
     * )
     */
    public function employer() {}

    /**
     * @OA\Get(
     *     path="/api/categorie",
     *     tags={"Categorie"},
     *     summary="recuperer tous les categories",
     *     description="Recuperer tous les types de categorie",
     *     operationId="getCategorie",
     *     @OA\Parameter(
     *         name="currentboutique",
     *         in="header",
     *         required=true,
     *         description="ID ou code de la boutique courante",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of type categories",
     *         @OA\JsonContent(
     *               type="array",
     *               @OA\Items(ref="#/components/schemas/Categorie")
     *         )
     *     )
     * )
     * 
     * @OA\Delete(
     *     path="/api/categorie/{id}",
     *     tags={"Categorie"},
     *     summary="Suppresion dune categorie",
     *     description="Suppresion dune categorie",
     *     @OA\Parameter(
     *         name="currentboutique",
     *         in="header",
     *         required=true,
     *         description="ID de la boutique courante",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la categorie",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categorie supprimé avec succès"
     *     )
     * )
     * 
     * @OA\Post(
     *     path="/api/categorie",
     *     tags={"Categorie"},
     *     summary="Créer une categorie",
     *     description="Créer une categorie",
     *     @OA\Parameter(
     *         name="currentboutique",
     *         in="header",
     *         required=true,
     *         description="ID ou code de la boutique courante",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"nom"},
     *                 @OA\Property(property="nom", type="string"),
     *                 @OA\Property(property="description", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Categorie cree avec succes",
     *         @OA\JsonContent(ref="#/components/schemas/Categorie")
     *     )
     * )
     *
     * @OA\Put(
     *     path="/api/categorie/{id}",
     *     tags={"Categorie"},
     *     summary="Modifie une categorie",
     *     description="Modifie une categorie",
     *     @OA\Parameter(
     *         name="currentboutique",
     *         in="header",
     *         required=true,
     *         description="ID de la boutique courante",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la categorie",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"nom"},
     *                 @OA\Property(property="nom", type="string"),
     *                 @OA\Property(property="description", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Categorie modifier avec succes",
     *         @OA\JsonContent(ref="#/components/schemas/Categorie")
     *     )
     * )
     */
    public function categorie() {}

    /**
     * @OA\Get(
     *     path="/api/produit",
     *     tags={"Produit"},
     *     summary="recuperer tous les produits",
     *     description="Recuperer tous les types de produit",
     *     operationId="getProduit",
     *     @OA\Parameter(
     *         name="currentboutique",
     *         in="header",
     *         required=true,
     *         description="ID ou code de la boutique courante",
     *         @OA\Schema(type="string")
     *     ),
     *    @OA\Response(
     *        response=200,
     *        description="List of type produits",
     *        @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Produit")
     *        )
     *    )
     * )
     * 
     * @OA\Get(
     *   path="/api/produit/{id}",
     *   tags={"Produit"},
     *   summary="recuperer un produit",
     *   description="Recuperer un produit",
     *   @OA\Parameter(
     *       name="currentboutique",
     *       in="header",
     *       required=true,
     *       description="ID ou code de la boutique courante",
     *       @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *       name="id",
     *       in="path",
     *       required=true,
     *       description="ID du produit",
     *       @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *       response=200,
     *       description="Produit récupéré avec succès",
     *       @OA\JsonContent(ref="#/components/schemas/Produit")
     *   )
     * )
     * 
     * @OA\Post(
     *    path="/api/produit",
     *    tags={"Produit"},
     *    summary="Créer un produit",
     *    description="Créer un produit",
     *    @OA\Parameter(
     *          name="currentboutique",
     *          in="header",
     *          required=true,
     *          description="ID ou code de la boutique courante",
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               required={"nom", "prixAchat", "prixVenteDetails", "prixVenteEngros", "quantite"},
     *               @OA\Property(property="nom", type="string"),
     *               @OA\Property(property="prixAchat", type="number", format="float"),
     *               @OA\Property(property="prixVenteDetails", type="number", format="float"),
     *               @OA\Property(property="prixVenteEngros", type="number", format="float"),
     *               @OA\Property(property="quantite", type="integer"),
     *               @OA\Property(property="id_categorie", type="integer"),
     *               @OA\Property(property="image", type="string", format="binary"),
     *               @OA\Property(property="description", type="string"),
     *           ),
     *        )
     *    ),
     *    @OA\Response(
     *          response=201,
     *          description="Produit créé avec succès",
     *          @OA\JsonContent(ref="#/components/schemas/Produit")
     *    )
     * )
     * 
     * @OA\Put(
     *      path="/api/produit/{id}",
     *      tags={"Produit"},
     *      summary="Modifier un produit",
     *      description="Modifier un produit",
     *      @OA\Parameter(
     *          name="currentboutique",
     *          in="header",
     *          required=true,
     *          description="ID ou code de la boutique courante",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID du produit",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *           required=true,
     *           @OA\MediaType(
     *                mediaType="multipart/form-data",
     *                @OA\Schema(
     *                      @OA\Property(property="nom", type="string"),
     *                      @OA\Property(property="prixAchat", type="number", format="float"),
     *                      @OA\Property(property="prixVenteDetails", type="number", format="float"),
     *                      @OA\Property(property="prixVenteEngros", type="number", format="float"),
     *                      @OA\Property(property="quantite", type="integer"),
     *                      @OA\Property(property="id_categorie", type="integer"),
     *                      @OA\Property(property="image", type="string", format="binary"),
     *                      @OA\Property(property="description", type="string"),
     *                ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Produit modifié avec succès",
     *          @OA\JsonContent(ref="#/components/schemas/Produit")
     *      )
     * )
     * 
     * @OA\Delete(
     *     path="/api/produit/{id}",
     *     tags={"Produit"},
     *     summary="Supprimer un produit",
     *     description="Supprimer un produit",
     *     @OA\Parameter(
     *        name="currentboutique",
     *        in="header",
     *        required=true,
     *        description="ID ou code de la boutique courante",
     *        @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *        description="ID du produit",
     *        @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *        response=200,
     *        description="Produit supprimé avec succès"
     *     )
     * )
     * 
     * @OA\Get(
     *    path="/api/produit/image/{name}",
     *    tags={"Produit"},
     *    summary="Recuperer l'image d'un produit",
     *    description="Recuperer l'image d'un produit",
     *    @OA\Parameter(
     *       name="currentboutique",
     *       in="header",
     *       required=true,
     *       description="ID ou code de la boutique courante",
     *       @OA\Schema(type="string")
     *    ),
     *    @OA\Parameter(
     *       name="name",
     *       in="path",
     *       required=true,
     *       description="nom de l'image du produit",
     *       @OA\Schema(type="string")
     *    ),
     *    @OA\Response(
     *       response=200,
     *       description="L'image a été récupérée avec succès",
     *       @OA\MediaType(
     *           mediaType="image/jpeg"
     *       )
     *    )
     * )
     * 
     * @OA\Delete(
     *    path="/api/produit/image/{id}",
     *    tags={"Produit"},
     *    summary="Supprimer une image d'un produit",
     *    description="Supprimer une image d'un produit ",
     *    @OA\Parameter(
     *        name="currentboutique",
     *        in="header",
     *        required=true,
     *        description="ID ou code de la boutique courante",
     *        @OA\Schema(type="string")
     *    ),
     *    @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *        description="ID ou code du produit",
     *        @OA\Schema(type="string")
     *    ),
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                @OA\Property(property="id", type="string", example="1"),
     *            )
     *        )
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="L'image a été supprimée avec succès"
     *    )
     * )
     * 
     * @OA\Post(
     *    path="/api/produit/image/{id}",
     *    tags={"Produit"},
     *    summary="Ajoute des images a un produit",
     *    description="Ajoute des images d'un produit ",
     *    @OA\Parameter(
     *        name="currentboutique",
     *        in="header",
     *        required=true,
     *        description="ID ou code de la boutique courante",
     *        @OA\Schema(type="string")
     *    ),
     *    @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *        description="ID ou code du produit",
     *        @OA\Schema(type="string")
     *    ),
     *    @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              @OA\Property(property="image", type="string", format="binary"),
     *          )
     *       )
     *    ),
     *    @OA\Response(
     *       response=200,
     *       description="L'image a été ajoutée avec succès",
     *    )
     * )
     */
    public function produit() {}

    /**
     * @OA\Get(
     *     path="/api/vente",
     *     tags={"Vente"},
     *     summary="recuperer toutes les ventes",
     *     description="Recuperer tous les ventes d'une boutique",
     *     operationId="getAllVente",
     *     @OA\Parameter(
     *         name="currentboutique",
     *         in="header",
     *         required=true,
     *         description="ID ou code de la boutique courante",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *        response=200,
     *        description="List des ventes",
     *        @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Vente")
     *        )
     *     )
     * )
     * 
     * @OA\Get(
     *     path="/api/vente/{id}",
     *     tags={"Vente"},
     *     summary="recuperer une vente",
     *     description="Recuperer une ventes d'une boutique avec les produits et le client",
     *     operationId="getVente",
     *     @OA\Parameter(
     *         name="currentboutique",
     *         in="header",
     *         required=true,
     *         description="ID ou code de la boutique courante",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="id de la vente",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *        response=200,
     *        description="la vente avec les produits",
     *        @OA\JsonContent(ref="#/components/schemas/Vente")
     *     )
     * ) 
     * 
     * @OA\Post(
     *     path="/api/vente",
     *     tags={"Ventes"},
     *     summary="Créer une nouvelle vente",
     *     description="Crée une nouvelle vente avec les informations du client et la liste des produits.",
     *     @OA\Parameter(
     *          name="currentboutique",
     *          in="header",
     *          required=true,
     *          description="ID de la boutique courante",
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          description="Informations de la vente à créer",
     *          @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"client", "produitsList", "is_detail"},
     *              @OA\Property(
     *                  property="client",
     *                  type="object",
     *                  description="Informations sur le client",
     *                  required={"telephone", "nomComplet"},
     *                  @OA\Property(property="nomComplet", type="string", example="Younouss Bore"),
     *                  @OA\Property(property="telephone", type="string", example="70000001"),
     *                  @OA\Property(property="email", type="string", format="email", example="client@example.com"),
     *                  @OA\Property(property="adresse", type="string", example="Bamako, Mali"),
     *                  @OA\Property(property="whatsapp", type="string", example="70000001")
     *                  ),
     *                  @OA\Property(
     *                       property="produitsList",
     *                       type="array",
     *                       description="Liste des produits vendus",
     *                       @OA\Items(
     *                           type="object",
     *                           required={"id", "quantite"},
     *                           @OA\Property(property="id", type="integer", description="ID du produit"),
     *                           @OA\Property(property="quantite", type="integer", description="Quantité du produit"),
     *                           @OA\Property(property="montant", type="number", format="float", description="Prix de vente unitaire (optionnel, sinon calculé automatiquement)")
     *                       )
     *                  ),
     *                  @OA\Property(
     *                       property="is_detail",
     *                       type="boolean",
     *                       description="Indique si la vente est au détail (true) ou en gros (false). Impacte le calcul du prix si non fourni dans produitsList."
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=201,
     *          description="Vente créée avec succès",
     *          @OA\JsonContent(
     *              description="Retourne l'objet de la vente créée.",
     *              ref="#/components/schemas/Vente"
     *          )
     *     ),
     *     @OA\Response(
     *          response=422,
     *          description="Erreur de validation des champs",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Erreur de validation des champs"),
     *              @OA\Property(property="errors", type="object")
     *          )
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Erreur interne du serveur",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Une erreur est survenue lors de la creation de la vente"),
     *              @OA\Property(property="error", type="string")
     *          )
     *     )
     * )
     * 
     * @OA\Delete(
     * path="/api/vente/{id}",
     * tags={"Ventes"},
     * summary="Supprimer une vente",
     * description="Supprime une vente spécifique en s'assurant qu'elle appartient à la boutique de l'utilisateur.",
     * @OA\Parameter(
     * name="currentboutique",
     * in="header",
     * required=true,
     * description="ID ou code de la boutique courante pour vérifier les autorisations.",
     * @OA\Schema(type="string")
     * ),
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID numérique de la vente à supprimer.",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Opération réussie",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Vente supprimer avec success")
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Ressource non trouvée",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Vente introuvable")
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Erreur interne du serveur",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Une erreur est survenue lors de la suppresion de la vente."),
     * @OA\Property(property="error", type="string")
     * )
     * )
     * )
     */
    public function vente() {}
}
