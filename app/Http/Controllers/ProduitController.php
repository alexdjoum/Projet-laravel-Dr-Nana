<?php

namespace App\Http\Controllers;

use App\Models\categorie;
use App\Models\photo;
use App\Models\produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduitController extends Controller
{
    public function index(Request $request)
    {
        //$baseUrl = url('/');

        $query = produit::query();
        $perPage = 9;
        $page = $request->input('page', 1);
        #Filtre avec le mot
        $search = $request->input('search');
        if ($search) {
            $query->where('nomPro', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'LIKE', '%' . $search . '%');
        }
        #Filtre par prix
        $prix1 = $request->input('prix1');
        $prix2 = $request->input('prix2');
        if ($prix1 && $prix2) {
            $query->whereBetween('prix', [$prix1, $prix2]);
        }

        $total = $query->count();
        $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->latest()->get();

        return $result;

        /*return response()->json([
            'status_code' => 200,
            'status_message' => 'Les produits ont ete recupere',
            'nombre_resultats' => $total,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
            'items' => $result
        ]);*/
    }


    public function produitsByCategorie(categorie $categorie, Request $request)
    {
        $query = produit::query();
        $perPage = 4;
        $page = $request->input('page', 1);
        $query->where('categorie_id', $categorie->id);
        $total = $query->count();
        $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->latest()->get();
        return $result;

    }

    public function show(produit $produit)
    {
        return $produit;
    }

    public function store(Request $request)
    {
        $produit = $request->validate([
            "codePro" => "required|numeric|unique:produits,codePro",
            "nomPro" => 'required|string',
            "prix" => 'required|numeric',
            "qte" => 'required|numeric',
            "description" => 'required|string',
            "codeArrivage" => 'required|string',
            "actif" => "boolean",
            "categorie_id" => "required|numeric",
            "prixAchat" => "required|numeric",
            "pourcentage" => 'required|numeric',
            "promo" => 'boolean'
        ]);
        $categorie_id = $request->categorie_id;

        unset($produit["categorie_id"]);
        $produit_creer = new produit($produit);
        $categorie = categorie::find($categorie_id);
        $categorie->produits()->save($produit_creer);

        return response()->json([
            "message" => "produit cree"
        ]);
    }

    public function update(produit $produit, Request $request)
    {
        $request->validate([
            "nomPro" => 'string',
            "prix" => 'numeric',
            "description" => 'string',
            "codeArrivage" => 'string',
            "actif" => "boolean",
            "categorie_id" => "numeric",
            "prixAchat" => "numeric",
            "pourcentage" => 'numeric',
            "promo" => 'boolean'
        ]);

        $request->nomPro && ($produit->nomPro = $request->nomPro);
        $request->prix && ($produit->prix = $request->prix);
        $request->description && ($produit->description = $request->description);
        $request->codeArrivage && ($produit->codeArrivage = $request->codeArrivage);
        $request->actif && ($produit->actif = $request->actif);
        $request->prixAchat && ($produit->prixAchat = $request->prixAchat);
        $request->pourcentage && ($produit->pourcentage = $request->pourcentage);
        $request->promo && ($produit->promo = $request->promo);

        $produit->save();

        return $produit;
    }

    public function destroy(produit $produit)
    {
        $produit->delete();
        return response()->json([
            "message" => "Produit supprime"
        ]);
    }

}
