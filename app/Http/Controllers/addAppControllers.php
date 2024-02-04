<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

/*
* C'est le contrôleur qui permet de gerer toutes les fonctionnalités de la vue "addApp".
*/
class addAppControllers extends Controller{

/*
|
| # A travers les requêtes ci-dessous, le système affiche les differents elements de la base de données. Les résultats seront transféré à la vue "addApp".
|
*/
    public function loadPageData(){

        // $apps = DB::table('apps')->select('appCode')->groupBy('appCode')->get();
        $statuses = DB::table('statuses')->select('statusID', 'statusName')->orderBy('statusID', 'ASC')->get();
        $departments = DB::table('departments')->select('departmentID', 'departmentName')->orderBy('departmentID', 'ASC')->get();
        $services = DB::table('services')->select('serviceID', 'serviceName')->orderBy('serviceID', 'ASC')->get();
        $editors = DB::table('editors')->select('editorID', 'editorName')->orderBy('editorID', 'ASC')->get();
        $solutiontypes = DB::table('solutiontypes')->select('solutiontypeID', 'solutiontypeName')->orderBy('solutiontypeID', 'ASC')->get();
        $applicationtypes = DB::table('applicationtypes')->select('applicationtypeID', 'applicationtypeName')->orderBy('applicationtypeID', 'ASC')->get();
        $architecturetypes = DB::table('architecturetypes')->select('architecturetypeID', 'architecturetypeName')->orderBy('architecturetypeID', 'ASC')->get();
        $platforms = DB::table('platforms')->select('platformID', 'platformName')->orderBy('platformID', 'ASC')->get();
        $databases = DB::table('databases')->select('databaseID', 'databaseName')->orderBy('databaseID', 'ASC')->get();
        $languages = DB::table('languages')->select('languageID', 'languageName')->where('deleted', false)->orderBy('languageID', 'ASC')->get();
        $middleware = DB::table('middleware')->select('middlewareID', 'middlewareName')->orderBy('middlewareID', 'ASC')->get();
    
        echo view('addApp', compact('apps', 'statuses', 'departments', 'services', 'editors', 'solutiontypes', 'applicationtypes', 'architecturetypes', 'platforms', 'databases', 'languages', 'middleware'));
    }

/*
|
| # Cette methode est executée à la demande de l'AJAX.
| # A travers la requête ci-dessous, le système affiche les differents codes des applications.
| Le résultat sera transféré à la vue "addApp". pour donner le choix a l'administrateur
| d'ajouter une nouvelle version...
|
*/
    public function getAppCodes(){
        $apps = DB::table('apps')->select('appCode')->groupBy('appCode')->get();
        return $apps;
    }

/*
|
| # Cette methode est executée à la demande de l'AJAX.
| # A travers la requête ci-dessous, le système charge les differents informations de la dernier version
| de l'application choisisée a travers son code.
|
*/
    public function getLastAppVersion($appCode){
        $app = DB::select(DB::raw('
            SELECT ap1.* FROM apps ap1 
            INNER JOIN (SELECT appCode, MAX(created_at) AS max_date FROM apps WHERE appCode = "' . $appCode . '" GROUP BY appCode) ap2 
            ON ap1.appCode = ap2.appCode AND ap1.created_at = ap2.max_date;
        '));
        return $app;
    }
    
/*
|
| # Cette méthode traite les informations de la nouvelle application saisie par l'administrateur 
| a fin de la sauvegarder dans la base de données
|
*/
    public function addApp(Request $req){
        if ($req->has('AppImg')) {
            $file = $req->AppImg;
            $fileName = 'AppIcon' . uniqid() . date('d-m-Y_H-i-s') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('Logos/AppLogos'), $fileName);
            $AppImgDBPath = '/Logos/AppLogos/' . $fileName;
        }else $AppImgDBPath = '/Logos/AppLogos/defaultImgApp.png';
        
        $newAppID = DB::table('apps')->insertGetId([
            'appCode' => $req->AppCode,
            'appName' => $req->AppName,
            'version' => $req->AppVersion,
            'description' => $this->checkNull($req->AppDesc),
            'status' => $req->AppStatus,
            
            'solutionType' => $req->AppTSlt,
            'architectureType' => $req->AppTArcht,
            'applicationType' => $req->AppTApp,
            
            'platform' => $req->AppPtf,
            'dataBase' => $req->AppDB,
            'middleware' => $req->AppMW,
            
            'appExe' => $req->aePath,
            'documentation' => $req->docPath,
            'sourceCode' => $req->scPath,
            'appIcon' => $AppImgDBPath,
            
            'department' => $req->AppDept,
            'service' => $req->AppServ,
            'editor' => $req->AppEditor,
            'employeeFK' => Session::get('employeeID')
        ]);

        $array =[];
        for ($i = 0; $i < count($req->AppLang); $i++) {
            $array[$i] = ['appFK' => $newAppID, 'languageFK' => $req->AppLang[$i]];
        }
        DB::table('appcoderassociations')->insert($array);

        return redirect('/AddApp');
    }

    public function checkNull($field){
        return ($field != null ) ? $field : "NULL";
    }
}