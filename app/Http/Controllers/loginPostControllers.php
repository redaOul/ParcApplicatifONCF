<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\sessionControllers;

/*
|
| # C'est le contrôleur qui permet de traiter les informations saisies par le visiteur.
| # Cette methode est executée à la demande de l'AJAX.
| # A travers la requete ci dessous, si la reponse et vide alors aucun utilisateur 
| dans la base de données a les informations saisies par le visiteur et pour ça le systeme envoie 
| le message d'erreur (Identifiant ou mot de passe incorrect). Si le cas contraire le systeme créé une session
| et envoie un message null pour le traiter par JavaScript après.
|
*/
class loginPostControllers extends Controller{
    public function auth(){
        $myData = json_decode($_POST["logInData"]);
        $emp = DB::table('employees')
                 ->where('login', '=', $myData->userId)
                 ->where('password', '=', $myData->userPswd)
                 ->first();
        if(!$emp){ 
            return "Identifiant ou mot de passe incorrect";
        }else{
            (new sessionControllers)->initSeesion($emp->employeeID, $emp->employeeName, $emp->employeeType);
            return null;
        }
    }
}