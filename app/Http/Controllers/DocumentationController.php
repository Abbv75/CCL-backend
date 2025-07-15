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
     *     description="Modèle de rôle (Joueur, Administrateur, etc.)",
     *     required={"id", "nom", "description"},
     *     @OA\Property(property="id", type="string", example="R01"),
     *     @OA\Property(property="nom", type="string", example="Joueur"),
     *     @OA\Property(property="description", type="string", example="Participant au tournoi")
     * )
     * 
     * @OA\Schema(
     *     schema="Contact",
     *     type="object",
     *     title="Contact",
     *     description="Modèle de contact utilisateur",
     *     required={"id", "telephone"},
     *     @OA\Property(property="id", type="string", format="uuid"),
     *     @OA\Property(property="telephone", type="string", example="+22390000000"),
     *     @OA\Property(property="email", type="string", nullable=true, example="exemple@mail.com"),
     *     @OA\Property(property="whatsapp", type="string", nullable=true, example="+22390000000"),
     *     @OA\Property(property="adresse", type="string", nullable=true, example="Bamako, Mali")
     * )
     * 
     * @OA\Schema(
     *     schema="User",
     *     type="object",
     *     title="User",
     *     description="Modèle d'utilisateur",
     *     required={"id", "nomComplet", "login", "id_role", "id_contact"},
     *     @OA\Property(property="id", type="string", format="uuid"),
     *     @OA\Property(property="nomComplet", type="string", example="Younouss Bore"),
     *     @OA\Property(property="login", type="string", example="younouss23"),
     *     @OA\Property(property="idCOD", type="string", nullable=true, example="COD123456"),
     *     @OA\Property(property="id_role", type="string", example="R01"),
     *     @OA\Property(property="id_contact", type="string", format="uuid"),
     *     @OA\Property(property="role", ref="#/components/schemas/Role"),
     *     @OA\Property(property="contact", ref="#/components/schemas/Contact")
     * )
     * 
     * @OA\Schema(
     *     schema="Status",
     *     type="object",
     *     title="Status",
     *     description="Modèle de statut",
     *     required={"id", "nom"},
     *     @OA\Property(property="id", type="string", example="S01"),
     *     @OA\Property(property="nom", type="string", example="En cours"),
     *     @OA\Property(property="description", type="string", example="une description du statut")
     * )
     * 
     * @OA\Schema(
     *     schema="Tournoi",
     *     type="object",
     *     title="Tournoi",
     *     description="Modèle de tournoi",
     *     required={"id", "nom", "id_status"},
     *     @OA\Property(property="id", type="string", format="uuid", example="9c75e6de-5b4e-4a9e-9bc8-16b6db479adb"),
     *     @OA\Property(property="nom", type="string", example="Tournoi Juillet 2025"),
     *     @OA\Property(property="dateDebut", type="string", format="date", nullable=true, example="2025-07-20"),
     *     @OA\Property(property="frais_inscription", type="number", format="float", nullable=true, example=2000),
     *     @OA\Property(property="montant_a_gagner", type="number", format="float", nullable=true, example=50000),
     *     @OA\Property(property="nb_max_participants", type="integer", nullable=true, example=100),
     *     @OA\Property(property="id_status", type="string", example="S01"),
     *     @OA\Property(property="status", ref="#/components/schemas/Status")
     * )
     * 
     * @OA\Schema(
     *     schema="Partie",
     *     type="object",
     *     title="Partie",
     *     description="Modèle de partie",
     *     required={"id", "dateHeure", "id_tournoi", "id_status"},
     *     @OA\Property(property="id", type="string", format="uuid", example="8a12f6de-3a4b-4bb1-9de3-16b6db479aa1"),
     *     @OA\Property(property="dateHeure", type="string", format="date-time", example="2025-08-01T14:30:00Z"),
     *     @OA\Property(property="id_tournoi", type="string", format="uuid", example="9c75e6de-5b4e-4a9e-9bc8-16b6db479adb"),
     *     @OA\Property(property="id_gagnant", type="string", format="uuid", nullable=true, example="7b65f3de-1a2c-4f88-9ec8-26c4fb478eef"),
     *     @OA\Property(property="id_status", type="string", example="S01"),
     *     @OA\Property(property="tournoi", ref="#/components/schemas/Tournoi"),
     *     @OA\Property(property="gagnant", ref="#/components/schemas/User"),
     *     @OA\Property(property="status", ref="#/components/schemas/Status"),
     *     @OA\Property(
     *         property="participants",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function schema() {}

    /**
     * @OA\Get(
     *     path="/api/role",
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
     *     path="/api/user",
     *     tags={"Users"},
     *     summary="Lister tous les utilisateurs",
     *     @OA\Response(
     *         response=200,
     *         description="Succès",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *     )
     * )
     * 
     * @OA\Get(
     *     path="/api/user/{id}",
     *     tags={"Users"},
     *     summary="Récupérer un utilisateur",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="UUID de l'utilisateur",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur trouvé",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     * 
     * @OA\Post(
     *     path="/api/user",
     *     tags={"Users"},
     *     summary="Créer un utilisateur",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nomComplet", "login", "id_role", "id_contact"},
     *             @OA\Property(property="nomComplet", type="string"),
     *             @OA\Property(property="login", type="string"),
     *             @OA\Property(property="idCOD", type="string", nullable=true),
     *             @OA\Property(property="id_role", type="string"),
     *             @OA\Property(property="id_contact", type="string", format="uuid")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Utilisateur créé",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     * 
     * @OA\Put(
     *     path="/api/user/{id}",
     *     tags={"Users"},
     *     summary="Mettre à jour un utilisateur",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="UUID de l'utilisateur",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nomComplet", type="string"),
     *             @OA\Property(property="login", type="string"),
     *             @OA\Property(property="idCOD", type="string", nullable=true),
     *             @OA\Property(property="id_role", type="string"),
     *             @OA\Property(property="id_contact", type="string", format="uuid")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur mis à jour",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     * 
     * @OA\Delete(
     *     path="/api/user/{id}",
     *     tags={"Users"},
     *     summary="Supprimer un utilisateur",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="UUID de l'utilisateur",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur supprimé"
     *     )
     * )
     * 
     * @OA\Get(
     *     path="/api/user/me",
     *     tags={"Users"},
     *     summary="Afficher mon profil connecté",
     *     @OA\Response(
     *         response=200,
     *         description="Profil utilisateur",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function users() {}

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     summary="Connexion d'un utilisateur",
     *     description="Permet à un utilisateur de se connecter en fournissant son login et son mot de passe",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"login", "password"},
     *             @OA\Property(property="login", type="string", example="younouss23"),
     *             @OA\Property(property="password", type="string", format="password", example="motDePasse123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Connexion réussie",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Connexion réussie"),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Identifiants invalides",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Identifiants invalides")
     *         )
     *     )
     * )
     */
    public function auth() {}

    /**
     * @OA\Get(
     *     path="/api/status",
     *     tags={"Status"},
     *     summary="Lister tous les statuts",
     *     description="Récupérer la liste de tous les statuts",
     *     @OA\Response(
     *         response=200,
     *         description="Succès",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Status"))
     *     )
     * )
     *
     * @OA\Get(
     *     path="/api/status/{id}",
     *     tags={"Status"},
     *     summary="Récupérer un statut par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du statut (ex: S01)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Statut trouvé",
     *         @OA\JsonContent(ref="#/components/schemas/Status")
     *     )
     * )
     *
     * @OA\Post(
     *     path="/api/status",
     *     tags={"Status"},
     *     summary="Créer un statut",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id", "nom"},
     *             @OA\Property(property="id", type="string", example="S01"),
     *             @OA\Property(property="nom", type="string", example="En cours")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Statut créé",
     *         @OA\JsonContent(ref="#/components/schemas/Status")
     *     )
     * )
     *
     * @OA\Put(
     *     path="/api/status/{id}",
     *     tags={"Status"},
     *     summary="Mettre à jour un statut",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du statut à mettre à jour",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nom", type="string", example="Terminé")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Statut mis à jour",
     *         @OA\JsonContent(ref="#/components/schemas/Status")
     *     )
     * )
     *
     * @OA\Delete(
     *     path="/api/status/{id}",
     *     tags={"Status"},
     *     summary="Supprimer un statut",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du statut à supprimer",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Statut supprimé avec succès"
     *     )
     * )
     */
    public function status() {}

    /**
     * @OA\Get(
     *     path="/api/tournoi",
     *     tags={"Tournois"},
     *     summary="Lister tous les tournois",
     *     description="Récupérer la liste complète des tournois",
     *     @OA\Response(
     *         response=200,
     *         description="Succès",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Tournoi"))
     *     )
     * )
     *
     * @OA\Get(
     *     path="/api/tournoi/{id}",
     *     tags={"Tournois"},
     *     summary="Récupérer un tournoi",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="UUID du tournoi",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tournoi trouvé",
     *         @OA\JsonContent(ref="#/components/schemas/Tournoi")
     *     )
     * )
     *
     * @OA\Post(
     *     path="/api/tournoi",
     *     tags={"Tournois"},
     *     summary="Créer un nouveau tournoi",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom", "id_status"},
     *             @OA\Property(property="nom", type="string", example="Tournoi Août 2025"),
     *             @OA\Property(property="dateDebut", type="string", format="date", nullable=true, example="2025-08-15"),
     *             @OA\Property(property="frais_inscription", type="number", format="float", nullable=true, example=2500),
     *             @OA\Property(property="montant_a_gagner", type="number", format="float", nullable=true, example=60000),
     *             @OA\Property(property="nb_max_participants", type="integer", nullable=true, example=120),
     *             @OA\Property(property="id_status", type="string", example="S01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tournoi créé",
     *         @OA\JsonContent(ref="#/components/schemas/Tournoi")
     *     )
     * )
     *
     * @OA\Put(
     *     path="/api/tournoi/{id}",
     *     tags={"Tournois"},
     *     summary="Mettre à jour un tournoi",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="UUID du tournoi à mettre à jour",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nom", type="string", example="Tournoi Septembre 2025"),
     *             @OA\Property(property="dateDebut", type="string", format="date", nullable=true, example="2025-09-10"),
     *             @OA\Property(property="frais_inscription", type="number", format="float", nullable=true, example=3000),
     *             @OA\Property(property="montant_a_gagner", type="number", format="float", nullable=true, example=70000),
     *             @OA\Property(property="nb_max_participants", type="integer", nullable=true, example=150),
     *             @OA\Property(property="id_status", type="string", example="S02")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tournoi mis à jour",
     *         @OA\JsonContent(ref="#/components/schemas/Tournoi")
     *     )
     * )
     *
     * @OA\Delete(
     *     path="/api/tournoi/{id}",
     *     tags={"Tournois"},
     *     summary="Supprimer un tournoi",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="UUID du tournoi à supprimer",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tournoi supprimé avec succès"
     *     )
     * )
     */
    public function tournois() {}


    /**
     * @OA\Get(
     *     path="/api/tournoi/{tournoi}/partie",
     *     tags={"Parties"},
     *     summary="Lister les parties d’un tournoi",
     *     @OA\Parameter(
     *         name="tournoi",
     *         in="path",
     *         required=true,
     *         description="UUID du tournoi",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liste des parties",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Partie"))
     *     )
     * )
     *
     * @OA\Get(
     *     path="/api/tournoi/{tournoi}/partie/{id}",
     *     tags={"Parties"},
     *     summary="Récupérer une partie d’un tournoi",
     *     @OA\Parameter(name="tournoi", in="path", required=true, description="UUID du tournoi", @OA\Schema(type="string", format="uuid")),
     *     @OA\Parameter(name="id", in="path", required=true, description="UUID de la partie", @OA\Schema(type="string", format="uuid")),
     *     @OA\Response(
     *         response=200,
     *         description="Partie trouvée",
     *         @OA\JsonContent(ref="#/components/schemas/Partie")
     *     )
     * )
     *
     * @OA\Post(
     *     path="/api/tournoi/{tournoi}/partie",
     *     tags={"Parties"},
     *     summary="Créer une nouvelle partie pour un tournoi",
     *     @OA\Parameter(name="tournoi", in="path", required=true, description="UUID du tournoi", @OA\Schema(type="string", format="uuid")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"dateHeure", "id_status"},
     *             @OA\Property(property="dateHeure", type="string", format="date-time", example="2025-08-01T14:30:00Z"),
     *             @OA\Property(property="id_gagnant", type="string", format="uuid", nullable=true, example="7b65f3de-1a2c-4f88-9ec8-26c4fb478eef"),
     *             @OA\Property(property="id_status", type="string", example="S01")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Partie créée", @OA\JsonContent(ref="#/components/schemas/Partie"))
     * )
     *
     * @OA\Put(
     *     path="/api/tournoi/{tournoi}/partie/{id}",
     *     tags={"Parties"},
     *     summary="Mettre à jour une partie",
     *     @OA\Parameter(name="tournoi", in="path", required=true, description="UUID du tournoi", @OA\Schema(type="string", format="uuid")),
     *     @OA\Parameter(name="id", in="path", required=true, description="UUID de la partie", @OA\Schema(type="string", format="uuid")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="dateHeure", type="string", format="date-time", example="2025-08-01T15:00:00Z"),
     *             @OA\Property(property="id_gagnant", type="string", format="uuid", nullable=true, example="7b65f3de-1a2c-4f88-9ec8-26c4fb478eef"),
     *             @OA\Property(property="id_status", type="string", example="S02")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Partie mise à jour", @OA\JsonContent(ref="#/components/schemas/Partie"))
     * )
     *
     * @OA\Delete(
     *     path="/api/tournoi/{tournoi}/partie/{id}",
     *     tags={"Parties"},
     *     summary="Supprimer une partie",
     *     @OA\Parameter(name="tournoi", in="path", required=true, description="UUID du tournoi", @OA\Schema(type="string", format="uuid")),
     *     @OA\Parameter(name="id", in="path", required=true, description="UUID de la partie", @OA\Schema(type="string", format="uuid")),
     *     @OA\Response(response=200, description="Partie supprimée avec succès")
     * )
     *
     * @OA\Post(
     *     path="/api/tournoi/{tournoi}/partie/participants/add",
     *     tags={"Parties"},
     *     summary="Ajouter des participants à une partie",
     *     @OA\Parameter(name="tournoi", in="path", required=true, description="UUID du tournoi", @OA\Schema(type="string", format="uuid")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_partie", "participants"},
     *             @OA\Property(property="id_partie", type="string", format="uuid"),
     *             @OA\Property(
     *                 property="participants",
     *                 type="array",
     *                 @OA\Items(type="string", format="uuid")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Participants ajoutés")
     * )
     *
     * @OA\Post(
     *     path="/api/tournoi/{tournoi}/partie/participants/remove",
     *     tags={"Parties"},
     *     summary="Supprimer des participants d’une partie",
     *     @OA\Parameter(name="tournoi", in="path", required=true, description="UUID du tournoi", @OA\Schema(type="string", format="uuid")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_partie", "participants"},
     *             @OA\Property(property="id_partie", type="string", format="uuid"),
     *             @OA\Property(
     *                 property="participants",
     *                 type="array",
     *                 @OA\Items(type="string", format="uuid")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Participants retirés")
     * )
     */
    public function parties() {}
}
