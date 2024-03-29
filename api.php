<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\ProduitController;
use App\Models\categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('produitsList', [ProduitController::class, 'index']);
Route::get('/produitByCategories/{categorie}', [ProduitController::class, 'produitsByCategorie']);
Route::get('/dropPhoto/{photo}', [ProduitController::class, 'dropPhotos']);
Route::post('/addPhoto/{produit}', [ProduitController::class, 'addPhotos']);

Route::post('/createCommade', [CommandeController::class, 'store']);
Route::get('/listCommade', [CommandeController::class, 'index']);
Route::post('/createVille', [CommandeController::class, 'createVille']);

Route::get('/listCategories', [CategorieController::class, 'index']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
