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
     *     @OA\Property(property="adresse", type="string"),
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
     *                 @OA\Property(property="adresse", type="string"),
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
     *                 @OA\Property(property="adresse", type="string"),
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
}
