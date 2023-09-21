<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['listCategorie']]);
    }

    public function listCategorie()
    {
        //
        $categorie=Categorie::all();
        return response()->json($categorie);

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
    public function store(StoreCategorieRequest $request)
    {
        $request->validated();
        $oldCategorie = Categorie::where('libelleCategorie', $request->libelleCategorie)->first();
        if($oldCategorie){
            return response()->json(['Cette catégorie existe déjà'],403);
            // Mon code d'erreur 403 signifie qu'il y'a risque de doublon
        }
        $categorie= new Categorie();
        $categorie->libelleCategorie= $request->libelleCategorie ;
        $categorie->save();
        return response()->json(['Ajout effectué avec succès'],403);

    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categorie $categorie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategorieRequest $request, Categorie $categorie)
    {
        //

        $categorie=Categorie::FindOrFail($categorie->id);
        $catVerif=Categorie::where('id','<>',$categorie->id)
          ->where('libelleCategorie',$request->libelleCategorie)->First();
        if($catVerif){
          return back()->with('error','Cette catégorie existe déjà');
        }
        $categorie->libelleCategorie=$request->libelleCategorie;
        $categorie->update();

            return response()->json("Modification effectue avec succes");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {
        //
        $categorie=Categorie::FindOrFail($categorie->id);
        $categorie->delete();
        return response()->json("Suppression effectuee avec succes");
    }
}
