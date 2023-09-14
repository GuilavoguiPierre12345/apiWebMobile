<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['listCategorie']]);
    // }

    public function listCategorie()
    {
        //
        if (Categorie::count()===0) return response()->json(["response"=>"La liste est vide"]); 
        $categorie=Categorie::orderBy('id','desc')->get();
        return response()->json(["response"=>$categorie]);

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
        if (!(auth()->check())) return response()->json(["message"=>"Veuillez vous identifier pour cette action !"]);

        $request->validated();
        $oldCategorie = Categorie::where('libelleCategorie', $request->libelleCategorie)->first();
        if($oldCategorie){
            return response()->json(["message"=>"Cette catégorie existe déjà"],403);
            // Mon code d'erreur 403 signifie qu'il y'a risque de doublon
        }
        $categorie= new Categorie();
        $categorie->libelleCategorie= $request->libelleCategorie ;
        $categorie->save();
        return response()->json(["message"=>'Ajout effectué avec succès']);
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
    public function update(Request $request)
    {
        //
        if (!(auth()->check())) return response()->json(["response"=>"Veuillez vous identifier pour cette action !"]);

        $categorie=Categorie::Find($request->id);
        $catVerif=Categorie::where('id','<>',$request->id)
          ->where('libelleCategorie',$request->libelleCategorie)->first();
        if($catVerif){
          return response()->json(["response"=>"Cette catégorie existe déjà"]);
        }
        $categorie->libelleCategorie=$request->libelleCategorie;
        $categorie->update();
        return response()->json(["response"=>"Modification effectue avec succes"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if (!(auth()->check())) return response()->json(["response"=>"Veuillez vous identifier pour cette action !"]);
        $categorie=Categorie::find($request->id);
        if(!$categorie) return response()->json(["response"=>"Cette categorie n'existe pas"]);
        $categorie->delete();
        return response()->json(["response"=>"Suppression effectuee avec succes"]);
    }
}
