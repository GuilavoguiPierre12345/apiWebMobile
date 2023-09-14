<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['store']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::orderBy('id','DESC')->get();
        if($users->count()===0)
            return response()->json(['response'=>'La liste des Utilisateurs est vide !']);
        return response()->json(['response'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        if ( (!isset($request->pseudo) || empty($request->pseudo) ) || 
        (!isset($request->password) || empty($request->password)) ||
        (!isset($request->genre) || empty($request->genre)))
        {
            return response()->json(["response" => "Une erreur se trouve dans vos informations !" ]);
        }
        if(strtoupper($request->genre) !== "M" && strtoupper($request->genre) !== "F"){
            return response()->json(["response" => "Le genre est soit M ou F !" ]);
        }
        $doublons = User::where("pseudo",$request->pseudo)->first();
        if($doublons){
            return response()->json(["response" =>"Erreur de doublon cet element existe deja"]);
        }
        $user = new User();
        $user->pseudo = $request->pseudo;
        $user->genre = strtoupper($request->genre);
        $user->password = $request->password;
        if ($request->hasFile('avatar')) {
            $fileName = 'avatar'.time().$request->avatar->getClientOriginalExtension();
            $filePath = 'storage/photos/users/'.$fileName;
            $request->avatar->storeAs('public/photos/users/',$fileName);
            $user->avatar = $filePath;
        }else
        $user->save();
        return response()->json(['response'=>"Utilisateur ajoute avec succes !"]);

      
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        //
        $user = User::findOrFail($request->id);
        if(!$user) {
            return response()->json(["message','Ce t'utilisateur n'existe pas !"]);
        }
        dd($request);
        $user = new User();
        $user->pseudo = $request->pseudo;
        $user->genre = strtoupper($request->genre);
        $user->fonction = $request->fonction;
        if ($request->hasFile('avatar')) {
            $fileName = 'avatar'.time().$request->avatar->getClientOriginalExtension();
            $filePath = 'storage/photos/users/'.$fileName;
            $request->avatar->storeAs('public/photos/users/',$fileName);
            $user->avatar = $filePath;
        }

        $user->save();
        return response()->json(['response'=>"Modification effectue avec succes !"]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::findOrFail($id);
        if(!$user)
            return response()->json("Cet user n'existe pas dans la base");

        $user->delete();
        return response()->json("Suppression effectuee avec succes");
    }
}
