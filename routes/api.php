<?php

use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TypeAbonnementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenteController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

Route::prefix('/users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
    Route::post('/login', [UserController::class, 'login']);
});

Route::prefix('/boutiques')->group(function () {
    Route::get('/', [BoutiqueController::class, 'index']);
    Route::get('/{id}', [BoutiqueController::class, 'show']);
    Route::get('image/{image}', [BoutiqueController::class, 'getImage']);
    Route::get('proprietaire/{id}', [BoutiqueController::class, 'getProprietaire']);

    Route::post('/', [BoutiqueController::class, 'store']);
    Route::post('/{id}', [BoutiqueController::class, 'update']);
    Route::post('/renouvellerAbonnement/{id}', [BoutiqueController::class, 'rennouvellerAbonnement']);
    Route::post('/resilierAbonnement/{id}', [BoutiqueController::class, 'resilierAbonnement']);


    Route::delete('/{id}', [BoutiqueController::class, 'destroy']);
});

Route::prefix('/roles')->group(function () {
    Route::get('/', [RoleController::class, 'index']);
});

Route::prefix('/type_abonnements')->group(function () {
    Route::get('/', [TypeAbonnementController::class, 'index']);
    Route::get('/{id}', [TypeAbonnementController::class, 'show']);
    Route::post('/', [TypeAbonnementController::class, 'store']);
    Route::put('/{id}', [TypeAbonnementController::class, 'update']);
    Route::delete('/{id}', [TypeAbonnementController::class, 'destroy']);
});

Route::prefix('/employer')->middleware('check.boutique')->group(function () {
    Route::get('/', [EmployerController::class, "index"]);
    Route::post('/', [EmployerController::class, "store"]);
    Route::put('/{id}', [EmployerController::class, "update"]);
    Route::delete('/{id}', [EmployerController::class, "delete"]);
});

Route::prefix('/categorie')->middleware('check.boutique')->group(function () {
    Route::get('/', [CategorieController::class, "index"]);
    Route::post('/', [CategorieController::class, "store"]);
    Route::put('/{id}', [CategorieController::class, "update"]);
    Route::delete('/{id}', [CategorieController::class, "delete"]);
});

Route::prefix('/produit')->middleware('check.boutique')->group(function () {
    Route::get('/', [ProduitController::class, "index"]);
    Route::get('/{id}', [ProduitController::class, "show"]);
    Route::post('/', [ProduitController::class, "store"]);
    Route::put('/{id}', [ProduitController::class, "update"]);
    Route::delete('/{id}', [ProduitController::class, "destroy"]);
    Route::get("image/{name}", [ProduitController::class, "getImage"]);
    Route::post('image/{id}', [ProduitController::class, "addImage"]);
    Route::delete('image/{id}', [ProduitController::class, "deleteImage"]);
});

Route::prefix('/vente')->middleware('check.boutique')->group(function () {
    Route::get('/', [VenteController::class, 'index']);
    Route::get('/{id}', [VenteController::class, 'show']);
    Route::post('/', [VenteController::class, 'create']);
    Route::delete('/{id}', [VenteController::class, 'delete']);
});


