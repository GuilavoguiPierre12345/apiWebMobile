<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['listProduit']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function listProduit()
    {
        //
        $produit=Produit::all();
        return response()->json($produit);
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
    public function store(StoreProduitRequest $request)
    {
        //
        $request->validated();
        $produit= new Produit();
        $produit->designation= $request->designation;
        $produit->prix= $request->prix;
        $produit->qte= $request->qte;
        $produit->categorie_id=$request->categorie_id;

        if($request->hasFile('lienImage')) {
            $file_extention = $request->lienImage->getClientOriginalExtension();
            $request->lienImage->storeAs('public/photo/produit',$request->designation.time().'.'.$file_extention);
            $path = 'storage/photo/produit'.$request->lienImage.time().'.'.$file_extention;
            $produit->lienImage = $path;
        }else{
            $produit->lienImage = "pas d'image téléchargé";
        }
        $produit->save();
        return response()->json(['Ajout effectué avec succès'],403);
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
    public function update(UpdateProduitRequest $request, Produit $produit)
    {
        $request->validated();
        $produit=Produit::FindOrFail($produit->id);
        $proVerif=Produit::where('id','<>',$produit->id)
          ->where('designation',$request->designation)->First();
        if($proVerif){
            return response()->json(['Cet produit existe déjà'],409);

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
    public function destroy(Produit $produit)
    {
        $produit=Produit::FindOrFail($produit->id);
        $produit->delete();
        return response()->json("Suppression effectuee avec succes");
    }
}
