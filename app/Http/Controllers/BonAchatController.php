<?php

namespace App\Http\Controllers;

use App\Models\bonAchat;
use App\Models\clientCarte;
use App\Models\facture;
use Exception;
use Illuminate\Http\Request;

class BonAchatController extends Controller
{
    public function store(clientCarte $clientCarte){
	
        try{
            $bonAchat= bonAchat::query()
                        ->whereBelongsTo($clientCarte)
                        ->where('actif',true)
                        ->first();
            
            if($bonAchat){
                $bonAchat->point+=$clientCarte->point;
                $bonAchat->montantGlobal+=$clientCarte->point*config('app.valeurUnitaire');
                $bonAchat->save();
            }else{
                $bonAchat = new bonAchat();
                $bonAchat->point=$clientCarte->point;
                $bonAchat->montantGlobal=$clientCarte->point*config('app.valeurUnitaire');
                $clientCarte->bonAchats()->save($bonAchat);
            }
            $clientCarte->point=0;
            $clientCarte->save();
	    $bonAchat= bonAchat::query()
                    ->whereBelongsTo($clientCarte)
                    ->where('actif',true)
                    ->first();
                
            
            return response()->json([
                'clientCarte' => $clientCarte->load("tontines"),
                'bonAchat'=>$bonAchat
            ]);
            //return back();
        }catch(Exception $e){
            return view(400);
        }
    }

    public function update(facture $facture){

        try{
            $ligneCarte = $facture->ligneCarte;
            $clientCarte=$ligneCarte->clientCarte;

            $bonAchat= bonAchat::query()
                        ->whereBelongsTo($clientCarte)
                        ->where('actif',true)
                        ->first();
        
            if($bonAchat && ($facture->montant*(1+$facture->tva/100))<=$bonAchat->montantGlobal){
                $bonAchat->actif=0;
                $facture->bonAchats()->save($bonAchat);

                foreach($facture->ligneFactures as $ligne){
                    $produit=$ligne->produit;
        
                    if($produit->qte<$ligne->qte){
                        $facture->montant-=$ligne->qte*$ligne->prix;
                        $facture->capital-=$ligne->qte*$ligne->capital;
                        $ligne->delete();
                    }else{
                        $produit->qte-=$ligne->qte;
                        $produit->save();
                    }
                }
            
                $facture->remise=0;
                $facture->paiementValid=1;
                $facture->save();

                return back()->with('success', 'Facture enregistree');
            }
            return back()->withErrors(['message' => 'Bon d\'achat insuffisant']);
        }catch(Exception $e){
            return view(400);
        }
    }
}
