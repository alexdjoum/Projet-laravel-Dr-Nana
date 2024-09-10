<?php

namespace App\Http\Controllers;

use App\Models\clientCarte;
use App\Models\tontine;
use Illuminate\Http\Request;

class TontineController extends Controller
{
    
    public function store(Request $request, clientCarte $clientCarte)
    {
        $tontine = $request->validate([
            'montant' => 'required|numeric',
            'commentaire' => 'string',
            'validite' => 'required|boolean',
            'action' => 'required|boolean'
        ]);
        //$user = auth()->user();

        $newTontine = tontine::create($tontine);
        $clientCarte->tontines()->save($newTontine);
        if ($tontine["action"]) {
            $clientCarte->montantTontine += $tontine["montant"];
        } else {
            $clientCarte->montantTontine -= $tontine["montant"];
        }
        //$user->tontines()->save($newTontine);
        $clientCarte->save();
        
        return response()->json([
            "message"=> "Création réussi",
            "Success"=> 'Ok'
        ], 200);
        //return back()->with('success', 'Tontine ajoutée');

    }
}
