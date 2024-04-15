<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\GestionnaireController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProduitFeaturesController;
use App\Models\facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/produitsList', [ProduitController::class, 'index']);
Route::get('/showProduit/{produit}', [ProduitController::class, 'show']);
Route::get('/produitByCategories/{categorie}', [ProduitController::class, 'produitsByCategorie']);
Route::post('/createProduit', [ProduitController::class, 'store']);
Route::post('/updateProduit/{produit}', [ProduitController::class, 'update']);


Route::get('/dropPhoto/{photo}', [ProduitFeaturesController::class, 'destroyPhotos']);
Route::post('/addPhoto/{produit}', [ProduitFeaturesController::class, 'storePhotos']);
Route::get('/dropSize/{size}', [ProduitFeaturesController::class, 'destroySize']);
Route::post('/addSize/{produit}', [ProduitFeaturesController::class, 'storeSize']);
Route::get('/dropColor/{color}', [ProduitFeaturesController::class, 'destroyColor']);
Route::post('/addColor/{produit}', [ProduitFeaturesController::class, 'storeColor']);


Route::post('/createCommande', [CommandeController::class, 'store']);
Route::post('/updateCommande/{commande}', [CommandeController::class, 'update']);
Route::get('/listCommande', [CommandeController::class, 'index']);
Route::post('/createVille', [CommandeController::class, 'createVille']);
Route::post('/faireAvance/{commande}', [CommandeController::class, 'faireAvance']);
Route::get('/dropCommande/{commande}', [CommandeController::class, 'destroy']);

Route::get('/listCategories', [CategorieController::class, 'index']);
Route::post('/createCategorie', [CategorieController::class, 'store']);
Route::post('/updateCategorie/{categorie}', [CategorieController::class, 'update']);
Route::get('/dropCategorie/{categorie}', [CategorieController::class, 'destroy']);

Route::post('/createGest', [GestionnaireController::class, 'store']);
Route::post('/loginGest', [GestionnaireController::class, 'login']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["middleware" => ['auth:sanctum']], function () {
    Route::get('/logoutGest', [GestionnaireController::class, 'logout']);
    Route::post('/createFac', [FactureController::class, 'store']);
});
