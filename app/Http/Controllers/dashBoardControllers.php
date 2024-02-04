<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/*
* C'est le contrôleur qui permet de gerer toutes les fonctionnalités de la vue "dashBoard".
*/
class dashBoardControllers extends Controller{

/*
|
| # A travers les requêtes ci-dessous, le système affiche les differents elements de la base de données. Les résultats seront transféré à la vue "dashBoard".
|
*/
    public function loadPageData(){
        $departments = DB::table('departments')->select('departmentID', 'departmentName')->orderBy('departmentID', 'ASC')->get();
        $services = DB::table('services')->select('serviceID', 'serviceName')->orderBy('serviceID', 'ASC')->get();
        $admins = DB::table('employees')->select('employeeID', 'employeeName','login')->where('employeeType','=','admin')->orderBy('employeeID', 'ASC')->get();
        $editors = DB::table('editors')->select('editorID', 'editorName')->orderBy('editorID', 'ASC')->get();
        $solutiontypes = DB::table('solutiontypes')->select('solutiontypeID', 'solutiontypeName')->orderBy('solutiontypeID', 'ASC')->get();
        $applicationtypes = DB::table('applicationtypes')->select('applicationtypeID', 'applicationtypeName')->orderBy('applicationtypeID', 'ASC')->get();
        $architecturetypes = DB::table('architecturetypes')->select('architecturetypeID', 'architecturetypeName')->orderBy('architecturetypeID', 'ASC')->get();
        $apitypes = DB::table('apitypes')->select('apitypeID', 'apitypeName')->orderBy('apitypeID', 'ASC')->get();
        $apiresponses = DB::table('apiresponses')->select('apiresponseID', 'apiresponseName')->orderBy('apiresponseID', 'ASC')->get();
        $platforms = DB::table('platforms')->select('platformID', 'platformName')->orderBy('platformID', 'ASC')->get();
        $databases = DB::table('databases')->select('databaseID', 'databaseName')->orderBy('databaseID', 'ASC')->get();
        $languages = DB::table('languages')->select('languageID', 'languageName')->where('deleted', false)->orderBy('languageID', 'ASC')->get();
        $middleware = DB::table('middleware')->select('middlewareID', 'middlewareName')->orderBy('middlewareID', 'ASC')->get();
        $statuses = DB::table('statuses')->select('statusID', 'statusName')->orderBy('statusID', 'ASC')->get();

        $apps = DB::select(DB::raw('
            SELECT ap1.appID, ap1.appCode, ap1.appName, ap1.version FROM apps ap1 
            INNER JOIN (SELECT appCode, MAX(created_at) AS max_date FROM apps GROUP BY appCode) ap2 
            ON ap1.appCode = ap2.appCode AND ap1.created_at = ap2.max_date
        '));
        $apis = DB::select(DB::raw('
            SELECT ap1.apiID, ap1.apiCode, ap1.apiName, ap1.version FROM apis ap1 
            INNER JOIN (SELECT apiCode, MAX(created_at) AS max_date FROM apis GROUP BY apiCode) ap2 
            ON ap1.apiCode = ap2.apiCode AND ap1.created_at = ap2.max_date
        '));

        return view('dashBoard', compact('departments', 'services', 'admins', 'editors', 'solutiontypes', 'applicationtypes', 'architecturetypes', 'apitypes', 'apiresponses', 'platforms', 'databases', 'languages', 'middleware', 'statuses', 'apps', 'apis'));
    }

/*
|
| # Cette methode pour supprimer l'element spécifié de la base de données.
|
*/
    public function deleteRow($tableName, $keyName, $rowID){
        if ($tableName != 'languages') {
            DB::table($tableName)
              ->where($keyName, '=', $rowID)
              ->delete();
            return redirect('/Dashboard');
        } else {
            DB::table($tableName)
              ->where($keyName, $rowID)
              ->update(['deleted' => true]);
            return redirect('/Dashboard');
        }
    }

/*
|
| # Cette methode est executée à la demande de l'AJAX.
| # Cette methode pour ajouter l'element spécifié de la base de données.
|
*/
    public function addRow($tableName, $keyName, $newRow){
        $Addquery = DB::table($tableName)
                  ->insertOrIgnore([ $keyName => $newRow]);

        if (($tableName == 'languages') && ($Addquery == 0)) {
            DB::table($tableName)
            ->where($keyName, $newRow)
            ->update(['deleted' => false]);
            return 1;
        } else {
            return $Addquery;
        }
    }

/*
|
| # Cette methode pour rétrograder un utilisateur du rang d’un administrateur à celui d’un employé.
|
*/
    public function delAdmin($adminID){
        DB::table('employees')
          ->where('employeeID', $adminID)
          ->update(['employeeType' => 'employee']);
        return redirect('/Dashboard');
    }

/*
|
| # Cette methode pour promouvoir les employés selectionnés au rang d’administrateur.
|
*/
    public function addAdmins(Request $request){
        $employees = $request->input('employees');
        DB::table('employees')
          ->whereIn('employeeID', $employees)
          ->update(['employeeType' => 'admin']);
        return redirect('/Dashboard');
    }

/*
|
| # Cette methode est executée à la demande de l'AJAX.
| # Cette methode charge tous les employés qui existent dans la base de donnés afin de promouvoir certains d'entre eux au rend d'administrateur
|
*/
    public function getEmp(){
        $employees = DB::table('employees')
                       ->select('employeeID', 'employeeName','login')
                       ->where('employeeType','=','employee')
                       ->orderBy('employeeID', 'ASC')
                       ->get();
        return $employees;
    }

/*
|
| # Cette methode est executée à la demande de l'AJAX.
| # Cette methode charge les informations détaillées de la dernier version de l'application choisie par le super-admin afin de la modifier
|
*/
    public function getLastApp($appID){
        $app = DB::table('apps')
        ->select('apps.*', 'employees.employeeName')
        ->join('employees', 'apps.employeeFK', '=', 'employees.employeeID')
        ->where('appID', $appID)
        ->get();

        $languages = DB::table('appcoderassociations')
        ->select('appCoderAssociationID', 'languageFK')
        ->where('appFK', $appID)
        ->get();

        return array_merge($app->toArray(), $languages->toArray());
    }

/*
|
| # Cette methode est executée à la demande de l'AJAX.
| # Cette methode charge les informations détaillées de la dernier version de l'API choisie par le super-admin afin de la modifier
|
*/
    public function getLastApi($apiID){
        $api = DB::table('apis')
        ->select('apis.*', 'employees.employeeName')
        ->join('employees', 'apis.employeeFK', '=', 'employees.employeeID')
        ->where('apiID', $apiID)
        ->get();

        $languages = DB::table('apicoderassociations')
        ->select('apiCoderAssociationID', 'languageFK')
        ->where('apiFK', $apiID)
        ->get();

        return array_merge($api->toArray(), $languages->toArray());
    }

/*
|
| # Cette methode traite les informations de l'application modifiée saisie par le super-admin a fin de sauvegarder ces modification dans la base de données
|
*/
    public function editApp(Request $request){
        if ($request->has('AppDoc')) $AppDocDBPath = '/' . Storage::put('App/Documentation/', $request->AppDoc);
        else $AppDocDBPath = $request->OldAppDoc;
        
        if ($request->has('AppImg')){
            $file = $request->AppImg;
            $fileName = 'AppIcon' . uniqid() . date('d-m-Y_H-i-s') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/Logos/AppLogos'), $fileName);
            $AppImgDBPath = '/Logos/AppLogos/' . $fileName;
        }else {
            $AppImgDBPath = $request->OldAppImg;
        }
        
        DB::table('apps')
        ->where('appID', $request->AppID)
        ->update([
            'appName' => $request->AppName,
            'version' => $request->AppVersion,
            'description' => $request->AppDesc,
            'status' => $request->AppStatus,
            'solutionType' => $request->AppTSlt,
            'architectureType' => $request->AppTArcht,
            'applicationType' => $request->AppTApp,
            'platform' => $request->AppPtf,
            'dataBase' => $request->AppDB,
            'middleware' => $request->AppMW,
            'documentation' => $AppDocDBPath,
            'appIcon' => $AppImgDBPath,
            'department' => $request->AppDept,
            'service' => $request->AppServ,
            'editor' => $request->AppEditor
        ]);

        DB::table('appcoderassociations')->where('appFK', $request->AppID)->delete();

        $array =[];
        for ($i = 0; $i < count($request->AppLang); $i++) {
            $array[$i] = ['appFK' => $request->AppID, 'languageFK' => $request->AppLang[$i]];
        }
        DB::table('appcoderassociations')->insert($array);

        return redirect('/Dashboard');
    }

/*
|
| # Cette methode traite les informations de l'API modifiée saisie par le super-admin a fin de sauvegarder ces modification dans la base de données
|
*/
    public function editApi(Request $request){
        
        if ($request->has('ApiDoc')) $ApiDocDBPath = '/' . Storage::put('Api/Documentation/', $request->ApiDoc);
        else $ApiDocDBPath = $request->OldApiDoc;

        if ($request->has('ApiImg')) {
            $file = $request->ApiImg;
            $fileName = 'ApiIcon' . uniqid() . date('d-m-Y_H-i-s') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('Logos/ApiLogos'), $fileName);
            $ApiImgDBPath = '/Logos/ApiLogos/' . $fileName;
        }else {
            $ApiImgDBPath = $request->OldApiImg;
        }
        
        DB::table('apis')
        ->where('apiID', $request->ApiID)
        ->update([
            'apiName' => $request->ApiName,
            'version' => $request->ApiVersion,
            'description' => $request->ApiDesc,
            'status' => $request->ApiStatus,
            'secutity' => $request->ApiSecurity,
            'apiType' => $request->ApiType,
            'apiResponse' => $request->ApiResponse,
            'dataBase' => $request->ApiDB,
            'middleware' => $request->ApiMW,
            'documentation' => $ApiDocDBPath,
            'apiIcon' => $ApiImgDBPath,
            'department' => $request->ApiDept,
            'service' => $request->ApiServ,
            'editor' => $request->ApiEditor
        ]);

        DB::table('apicoderassociations')->where('apiFK', $request->ApiID)->delete();

        $array =[];
        for ($i = 0; $i < count($request->ApiLang); $i++) {
            $array[$i] = ['apiFK' => $request->ApiID, 'languageFK' => $request->ApiLang[$i]];
        }
        DB::table('apicoderassociations')->insert($array);

        return redirect('/Dashboard');
    }
}