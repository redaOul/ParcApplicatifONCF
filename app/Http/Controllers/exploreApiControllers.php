<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/*
* C'est le contrôleur qui permet de gerer toutes les fonctionnalités de la vue "exploreApi".
*/
class exploreApiControllers extends Controller{

/*
|
| # A travers la requête ci-dessous, le système regroupe les APIs par leur code pour afficher 
| des informations sur la dernière version de chaque API. Le résultat sera transféré à la vue "exploreApp".
|
*/
    public function loadPageData(){
        $apis = DB::select(DB::raw('
            SELECT ap1.*, employees.employeeName FROM apis ap1 
            JOIN employees ON ap1.employeeFK = employees.employeeID 
            INNER JOIN (SELECT apiCode, MAX(created_at) AS max_date FROM apis GROUP BY apiCode) ap2 
            ON ap1.apiCode = ap2.apiCode AND ap1.created_at = ap2.max_date
        '));
        return view('exploreApi', compact('apis'));
    }

/*
|
| # Cette methode est executée à la demande de l'AJAX.
| # A travers les requête ci-dessous, le système regroupe les APIs qui ont le code ($aipCode) pour afficher 
| les informations sur la dernière version de l'API. Le résultat sera transféré à la vue "exploreApi".
| Puis les langages utilisé pour coder cette API. enfin les nombres de differents version de l'API.
|
*/
    public function getApi($apiCode){
        $api = DB::select(DB::raw('
            SELECT ap1.*, employees.employeeName FROM apis ap1 
            JOIN employees ON ap1.employeeFK = employees.employeeID 
            INNER JOIN (SELECT apiCode, MAX(created_at) AS max_date FROM apis WHERE apiCode = "' . $apiCode . '" GROUP BY apiCode) ap2 
            ON ap1.apiCode = ap2.apiCode AND ap1.created_at = ap2.max_date
        '));

        $language = DB::table('apicoderassociations')
        ->select('languages.languageName')
        ->join('languages', 'apicoderassociations.languageFK', '=', 'languages.languageID')
        ->where('apicoderassociations.apiFK', $api[0]->apiID)
        ->get();

        $version = DB::table('apis')
        ->select('apiID', 'version')
        ->where('apiCode', $apiCode)
        ->get();
        $array = array_merge($api, $language->toArray(), $version->toArray());

        return $array;
    }

/*
|
| # Cette methode est executée à la demande de l'AJAX.
| # A travers les requête ci-dessous, le système retourne (documentation et le code source)
| de l'API qui a l'identifiant ($apiID) pour donner la main a l'employé de les telecharger après.
|
*/
    public function getApiFiles($apiID){
        $apiAttachment = DB::table('apis')
        ->select('apiID', 'documentation', 'sourceCode')
        ->where('apiID', $apiID)
        ->get()
        ->first();

        return $apiAttachment;
    }

/*
|
| # A travers les requête ci-dessous, le système retourne les applications qui ont le meme nom que 
| le nom saisie par l'emplyé ($req->apiName).
|
*/
    public function searchApi(Request $req){
        $apis = DB::table('apis')
        ->select('apis.*', 'employees.employeeName')
        ->join('employees', 'apis.employeeFK', '=', 'employees.employeeID')
        ->where('apis.apiName', $req->apiName)
        ->orderBy('apis.created_at', 'DESC')
        ->limit(1)
        ->get();
        return view('exploreApi', compact('apis'));
    }

/*
|
| # Cette meéthode permet de telecharger le fichier qui a le chemin ($path).
| # Cette méthode a besoin des modifications pour supporter le telechargement des fichiers massives
|
*/
    public function downloadAttachment($path){
        return Storage::download($path);
    }
}
