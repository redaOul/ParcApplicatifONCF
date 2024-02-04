<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

/*
* C'est le contrôleur qui permet de gerer toutes les fonctionnalités de la vue "addApi".
*/
class addApiControllers extends Controller{

/*
|
| # A travers les requêtes ci-dessous, le système affiche les differents elements de la base de données. Les résultats seront transféré à la vue "addApi".
|
*/
    public function loadPageData(){
        // $apis = DB::table('apis')->select('apiCode')->groupBy('apiCode')->get();
        $statuses = DB::table('statuses')->select('statusID', 'statusName')->orderBy('statusID', 'ASC')->get();
        $departments = DB::table('departments')->select('departmentID', 'departmentName')->orderBy('departmentID', 'ASC')->get();
        $services = DB::table('services')->select('serviceID', 'serviceName')->orderBy('serviceID', 'ASC')->get();
        $editors = DB::table('editors')->select('editorID', 'editorName')->orderBy('editorID', 'ASC')->get();
        $apitypes = DB::table('apitypes')->select('apitypeID', 'apitypeName')->orderBy('apitypeID', 'ASC')->get();
        $apiresponses = DB::table('apiresponses')->select('apiresponseID', 'apiresponseName')->orderBy('apiresponseID', 'ASC')->get();
        $databases = DB::table('databases')->select('databaseID', 'databaseName')->orderBy('databaseID', 'ASC')->get();
        $languages = DB::table('languages')->select('languageID', 'languageName')->where('deleted', false)->orderBy('languageID', 'ASC')->get();
        $middleware = DB::table('middleware')->select('middlewareID', 'middlewareName')->orderBy('middlewareID', 'ASC')->get();

        echo view('addApi', compact('apis', 'statuses', 'departments', 'services', 'editors', 'apitypes', 'apiresponses', 'databases', 'languages', 'middleware'));
    }

/*
|
| # Cette methode est executée à la demande de l'AJAX.
| # A travers la requête ci-dessous, le système affiche les differents codes des APIs. 
| Le résultat sera transféré à la vue "addApi". pour donner le choix a l'administrateur
| d'ajouter une nouvelle version...
|
*/
    public function getApiCodes(){
        $apis = DB::table('apis')->select('apiCode')->groupBy('apiCode')->get();
        return $apis;
    }

/*
|
| # Cette methode est executée à la demande de l'AJAX.
| # A travers la requête ci-dessous, le système charge les differents informations de la dernier version
| de l'API choisisée a travers son code.
|
*/
    public function getLastApiVersion($apiCode){
        $api = DB::select(DB::raw('
            SELECT ap1.* FROM apis ap1 
            INNER JOIN (SELECT apiCode, MAX(created_at) AS max_date FROM apis WHERE apiCode = "' . $apiCode . '" GROUP BY apiCode) ap2 
            ON ap1.apiCode = ap2.apiCode AND ap1.created_at = ap2.max_date;
        '));
        return $api;
    }
    
/*
|
| # Cette méthode traite les informations de la nouvelle API saisie par l'administrateur 
| a fin de la sauvegarder dans la base de données
|
*/
    public function addApi(Request $req){
        if ($req->has('ApiImg')) {
            $file = $req->ApiImg;
            $fileName = 'ApiIcon' . uniqid() . date('d-m-Y_H-i-s') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('Logos/ApiLogos'), $fileName);
            $ApiImgDBPath = '/Logos/ApiLogos/' . $fileName;
        }else $ApiImgDBPath = '/Logos/ApiLogos/defaultImgApi.png';
        
        $newApiID = DB::table('apis')->insertGetId([
            'apiCode' => $req->ApiCode,
            'apiName' => $req->ApiName,
            'version' => $req->ApiVersion,
            'description' => $this->checkNull($req->ApiDesc),
            'status' => $req->ApiStatus,
            'secutity' => $req->ApiSecurity,

            'apiType' => $req->ApiType,
            'apiResponse' => $req->ApiResponse,
            
            'dataBase' => $req->ApiDB,
            'middleware' => $req->ApiMW,
            
            'documentation' => $req->docPath,
            'sourceCode' => $req->scPath,
            'apiIcon' => $ApiImgDBPath,
            
            'department' => $req->ApiDept,
            'service' => $req->ApiServ,
            'editor' => $req->ApiEditor,
            'employeeFK' => Session::get('employeeID')
        ]);

        $array =[];
        for ($i = 0; $i < count($req->ApiLang); $i++) {
            $array[$i] = ['apiFK' => $newApiID, 'languageFK' => $req->ApiLang[$i]];
        }
        DB::table('apicoderassociations')->insert($array);

        return redirect('/AddApi');
    }

    public function checkNull($field){
        return ($field != null ) ? $field : "NULL";
    }
}