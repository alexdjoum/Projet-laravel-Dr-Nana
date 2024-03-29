<?php

namespace App\Http\Controllers;

use App\Models\categorie;
use App\Models\photo;
use App\Models\produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index(Request $request)
    {
        $query = produit::query();
        $perPage = 4;
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
        return response()->json([
            'status_code' => 200,
            'status_message' => 'Les produits ont ete recupere',
            'nombre_resultats' => $total,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
            'items' => $result
        ]);
    }


    public function produitsByCategorie(categorie $categorie, Request $request)
    {
        $query = produit::query();
        $perPage = 4;
        $page = $request->input('page', 1);

        $query->where('categorie_id', $categorie->id);

        $total = $query->count();
        $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->latest()->get();
        return response()->json([
            'status_code' => 200,
            'status_message' => 'Les produits ont ete recupere',
            'nombre_resultats' => $total,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
            'items' => $result
        ]);

    }

    public function dropPhotos(photo $photo)
    {

        $value = $photo->delete();
        return response()->json([
            'status_code' => 200,
            'status_message' => "Photo supprime"
        ]);
    }

    public function addPhotos(produit $produit, Request $request)
    {
        $photo = $request->validate([
            "lienPhoto" => 'required|string'
        ]);
        $photo_creer = new photo($photo);
        $produit->photos()->save($photo_creer);

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Photo ajouter',
        ]);
    }
}
