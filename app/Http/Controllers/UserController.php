<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // Renvoyer tous les users (/users)
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create($request->all());
    
        return [
            "data" => $user
        ];
    }

    /**
     * Display the specified resource.
     */
    // Renvoyer l'user d'id précis (/users/{id})
    public function show(string $id)
    {
        // "where(a, b)" vérifie que a, dans la base de données, est égal à b dans la requête.
        return User::where('id', $id)->first();
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
        User::where('id', $id)->delete();
    }

    // Session

    public function login(Request $request) {
        // On récupère, sans vérifier s'il existe, le premier utilisateur dont l'e-mail correspond à celui spécifié dans la requête
        $user = User::where('email', $request->email)->first();
        
        /* On vérifie :
            - qu'un utilisateur avec l'e-mail spécifié existe dans la base de données
            - que le hash du mot de passe associé correspond au hash de l'utilisateur 
        */
        if(!$user || !Hash::check($request->password, $user->password)) {
            throw new AuthorizationException();
        }

        // On crée un token, qui identifie l'utilisateur.
        // Le token est nommé, par nous, 'access_token', accorde tous les droits (*) et expire un an après l'instant de la création
        $token = $user->createToken('access_token', ['*'], now()->plus(years: 1));
        
        // On renvoie un tableau, qui est aussi un tableau associatif, afin de gérer les "sacs de réponse" ("data", "errors", "meta")
        // Ici, on choisit de ne renvoyer que le sac "data", car nous avons géré les erreurs dans le 'if' plus haut, avec 'throw'
        return  [
            "data" => $token->plainTextToken
        ];
   
    }

    public function getLoggedUser(Request $request) {
        // Renvoie le token utilisé pour la connexion actuelle
        return [
            "data" => $request->user()
        ];
    }

    public function logout(Request $request) {
        // L'utilisateur est déconnecté en supprimant le token utilisé pour la connexion actuelle
        $request->user()->currentAccessToken()->delete();
    }
}