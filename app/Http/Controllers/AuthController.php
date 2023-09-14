<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    // la methode pour la connexion
    public function login()
    {
        // les informations d'authentification 
        $credentials = request(['pseudo', 'password']);

        // si les informations d'authentification ne sont pas correct, on envoi un message d'erreur
        // le code 401 indique que l'autorisation n'est pas acceptee
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['response' => "Informations d'Authentification incorrect !"], 401);
        }
        // retourner le token si les informations sont correcte
        return $this->respondWithToken($token);
    }

    // la methode qui retourne les informations de l'utilisateur connecte
    public function connectedUser()
    {
        return response()->json(["response",auth()->user()]);
    }

    // la methode qui permet a l'utilisateur de se deconnecte
    public function logout()
    {
        auth()->logout();

        return response()->json(['response' => 'Vous etes deconnecte avec succes']);
    }

    // la methode qui permet de reactualiser le token d'authentification de l'utilisateur
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    // la methode qui definit le token d'authentification de l'utilisateur
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
