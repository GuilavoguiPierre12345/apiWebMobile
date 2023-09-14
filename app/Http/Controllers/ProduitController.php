<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['listProduit']]);
    // }

    /**
     * Display a listing of the resource.
     */
    public function listProduit()
    {
        //
        $produit=Produit::orderBy('id','desc')->get();
        return response()->json(["response"=>$produit]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        if (!(auth()->check())) return response()->json(["response"=>"Veuillez vous identifier pour cette action !"]);

        if ( (!isset($request->designation) || empty($request->designation) ) || 
        (!isset($request->prix) || empty($request->prix)) ||
        (!isset($request->lienImage) || empty($request->lienImage)) ||
        (!isset($request->qte) || empty($request->qte)) ||
        (!isset($request->status) || empty($request->status)) ||
        (!isset($request->categorie_id) || empty($request->categorie_id))) return response()->json(["response" => "Veuillez remplir tout les champs" ]);


        $produit= new Produit();
        $produit->designation= $request->designation;
        $produit->prix= floatval($request->prix);
        $produit->qte= intval($request->qte);
        $produit->categorie_id=intval($request->categorie_id);
        $produit->status=$request->status;

        if($request->hasFile('lienImage')) {
            $file_extention = $request->lienImage->getClientOriginalExtension();
            $request->lienImage->storeAs('public/photo/produit',$request->designation.time().'.'.$file_extention);
            $path = 'storage/photo/produit'.$request->lienImage.time().'.'.$file_extention;
            $produit->lienImage = $path;
        }else{
            $produit->lienImage = "pas d'image téléchargé";
        }
        $produit->update();
        return response()->json(["response"=>'Ajout effectué avec succès']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produit $produit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (!(auth()->check())) return response()->json(["response"=>"Veuillez vous identifier pour cette action !"]);

        if ( (!isset($request->designation) || empty($request->designation) ) || 
        (!isset($request->prix) || empty($request->prix)) ||
        (!isset($request->lienImage) || empty($request->lienImage)) ||
        (!isset($request->qte) || empty($request->qte)) ||
        (!isset($request->status) || empty($request->status)) ||
        (!isset($request->categorie_id) || empty($request->categorie_id))) return response()->json(["response" => "Veuillez remplir tout les champs" ]);

        $produit=Produit::find($request->id);
        $proVerif=Produit::where('id','<>',$request->id)
          ->where('designation',$request->designation)->first();
        if($proVerif){
            return response()->json(["response"=>'Cet produit existe déjà'],409);
        }

        $produit->designation= $request->designation;
        $produit->prix= $request->prix;
        $produit->qte= $request->qte;
        $produit->categorie_id=$request->categorie_id;
        $produit->status=$request->status;

        if ($request->hasFile('lienImage')) {
            $uploadedFile = $request->file('lienImage');
            $fileName = 'produit' . time() . '.' . $uploadedFile->getClientOriginalExtension();
            $filePath = 'public/photo/produit';
            // Stockez le fichier avec un nom personnalisé
            Storage::putFileAs($filePath, $uploadedFile, $fileName);
            // Enregistrez le chemin de la nouvelle image dans la base de données
            $produit->lienImage = $filePath . '/' . $fileName;
        }
        $produit->update();
        return response()->json(['Modification effectué avec succès'],408);



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $produit=Produit::find($request->id);
        if(!$produit) return response()->json(["response"=>"Produit not found"]); 
        $produit->delete();
        return response()->json(["response"=>"Suppression effectuee avec succes"]);
    }
    
}
