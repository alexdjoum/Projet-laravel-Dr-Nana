<?php

namespace App\Http\Controllers;

use App\Models\commande;
use App\Models\ligneCommande;
use App\Models\ville;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = commande::query();
        $perPage = 4;
        $page = $request->input('page', 1);

        $total = $query->count();
        $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->latest()->get();
        return response()->json([
            'status_code' => 200,
            'status_message' => 'La liste des commandes',
            'nombre_resultats' => $total,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
            'items' => $result
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $commande = $request->validate([
            "montant" => ["required", "numeric"],
            "nomClient" => ["required", "string", "min:2", "max:30"],
            "mobile" => ["required", "string", "max:20"],
            "addresse" => ["string"],
            "avance" => ["numeric"],
            "remise" => ["numeric"],
            "ville_id" => 'numeric',
            "productList" => 'required|array|min:1'
        ]);
        $productList = $commande["productList"];

        if (isset ($commande["ville_id"])) {
            $ville_id = $commande["ville_id"];
            unset($commande["ville_id"]);
        }
        unset($commande["productList"]);


        $commande_creer = commande::create($commande);

        foreach ($productList as $product) {
            $ligne_creer = new ligneCommande($product);
            $commande_creer->ligneCommandes()->save($ligne_creer);
        }

        if (isset ($ville_id)) {
            $ville = ville::find($ville_id);
            if (isset ($ville)) {
                $ville->commandes()->save($commande_creer);
            }
        }

        return response()->json([
            'status_code' => 200,
            'status_message' => 'ok',
            "Commande" => $commande_creer
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function createVille(Request $request)
    {
        $ville = $request->validate([
            "libelle" => 'required|string'
        ]);
        $ville_creer = ville::create($ville);
        return response()->json([
            "status_code" => 200,
            "Status_message" => "ville creer",
            "ville" => $ville_creer
        ]);
    }
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
