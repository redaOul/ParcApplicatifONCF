<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/*
* C'est le contrôleur qui permet de gerer toutes les fonctionnalités de la vue "exploreApp".
*/
class exploreAppControllers extends Controller{

/*
|
| # A travers la requête ci-dessous, le système regroupe les applications par leur code pour afficher 
| des informations sur la dernière version de chaque application. Le résultat sera transféré à la vue "exploreApp".
|
*/
    public function loadPageData(){
        $apps = DB::select(DB::raw('
            SELECT ap1.*, employees.employeeName FROM apps ap1 
            JOIN employees ON ap1.employeeFK = employees.employeeID 
            INNER JOIN (SELECT appCode, MAX(created_at) AS max_date FROM apps GROUP BY appCode) ap2 
            ON ap1.appCode = ap2.appCode AND ap1.created_at = ap2.max_date
        '));
        return view('exploreApp', compact('apps'));
    }

/*
|
| # Cette methode est executée à la demande de l'AJAX.
| # A travers les requête ci-dessous, le système regroupe les applications qui ont le code ($appCode) pour afficher 
| les informations sur la dernière version de l'application. Le résultat sera transféré à la vue "exploreApp".
| Puis les langages utilisé pour coder cette application. enfin les nombres de differents version de l'application.
|
*/
    public function getApp($appCode){
        $app = DB::select(DB::raw('
            SELECT ap1.*, employees.employeeName FROM apps ap1 
            JOIN employees ON ap1.employeeFK = employees.employeeID 
            INNER JOIN (SELECT appCode, MAX(created_at) AS max_date FROM apps WHERE appCode = "' . $appCode . '" GROUP BY appCode) ap2 
            ON ap1.appCode = ap2.appCode AND ap1.created_at = ap2.max_date
        '));

        $language = DB::table('appcoderassociations')
        ->select('languages.languageName')
        ->join('languages', 'appcoderassociations.languageFK', '=', 'languages.languageID')
        ->where('appcoderassociations.appFK', $app[0]->appID)
        ->get();

        $version = DB::table('apps')
        ->select('appID', 'version')
        ->where('appCode', $appCode)
        ->get();
        $array = array_merge($app, $language->toArray(), $version->toArray());

        return $array;
    }

/*
|
| # Cette methode est executée à la demande de l'AJAX.
| # A travers les requête ci-dessous, le système retourne (l'application executable, documentation et le code source)
| de l'application qui a l'identifiant ($appID) pour donner la main a l'employé de les telecharger après.
|
*/
    public function getAppFiles($appID){
        $appAttachment = DB::table('apps')
        ->select('appID', 'appExe', 'documentation', 'sourceCode')
        ->where('appID', $appID)
        ->get()
        ->first();

        return $appAttachment;
    }

/*
|
| # A travers les requête ci-dessous, le système retourne les applications qui ont le meme nom que 
| le nom saisie par l'emplyé ($req->appName).
|
*/
    public function searchApp(Request $req){
        $apps = DB::table('apps')
        ->select('apps.*', 'employees.employeeName')
        ->join('employees', 'apps.employeeFK', '=', 'employees.employeeID')
        ->where('apps.appName', $req->appName)
        ->orderBy('apps.created_at', 'DESC')
        ->limit(1)
        ->get();
        return view('exploreApp', compact('apps'));
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
