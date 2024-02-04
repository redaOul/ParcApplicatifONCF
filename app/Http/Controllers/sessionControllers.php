<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

/*
* C'est le contrôleur qui permet de gerer la session d'un visiteur.
*/
class sessionControllers extends Controller{

/*
|
| # A l'aide de cette méthode, le système crée une session qui sera detruite 
| apres un certain moment de l'inactivité ou apres la deconnexion manuelle.
| # la session qui sera créer contient l'identifiant, le nom et le type
| d'utilisateur (employé, administrateur ou super-admin).
|
*/
    public function initSeesion($eID, $eName, $eType){
        Session::put('employeeID', $eID);
        Session::put('employeeName', $eName);
        Session::put('employeeType', $eType);
    }

/*
|
| # Cette méthode permet de verifier l'existance de la session par la verification s'il existe
| un identifiant de l'utilisateur.
|
*/
    public function checkSeesion(){
        if( Session::has('employeeID') ){
            return true;
        }else {
            return false;
        }
    }

/*
|
| # Cette méthode permet de detruire la session manuellement
| apres le clic sur deconnexion.
|
*/
    public function destroySeesion(){
        Session::flush();
        return redirect('/');
    }
}
