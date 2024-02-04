<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\loginPostControllers;
use App\Http\Controllers\dashBoardControllers;
use App\Http\Controllers\addAppControllers;
use App\Http\Controllers\addApiControllers;
use App\Http\Controllers\exploreAppControllers;
use App\Http\Controllers\exploreApiControllers;
use App\Http\Controllers\RecieverBigFiles;
use App\Http\Controllers\sessionControllers;



/*
|--------------------------------------------------------------------------
| Login Routes
|--------------------------------------------------------------------------
|
| premier route permit de charger la page "login" s'il est demandé a travers la methode GET et si le visiteur n'a pas deja faire l'authentification
| deuxième route utilisée pour envoyer les informations saisies par le visiteur à la methode chargée de les traiter
| troisième route est utilisée pour exécuter la methode qui destruite la session et etre rederiger vers la page "Login"
|
*/
Route::get('/', function () {
    if (Session::has('employeeID')) return redirect('/Accueil');
    else return view('login');
});
Route::post('/contollers/login', [loginPostControllers::class, 'auth']);
Route::post('/contollers/logout', [sessionControllers::class, 'destroySeesion']);

/*
|--------------------------------------------------------------------------
| Accueil Routes
|--------------------------------------------------------------------------
|
| Ce route permit de charger la page du "home" s'il est demandé a travers la methode GET et si le visiteur n'a pas deja faire l'authentification
|
*/
Route::get('/Accueil', function () {
    if (Session::has('employeeID')) return view('home');
    else return redirect('/');
});

/*
|--------------------------------------------------------------------------
| ExploreApp Routes
|--------------------------------------------------------------------------
|
| premier route est utilisé pour executer la méthode qui charge la page "exploreApp" s'il est demandé a travers la methode GET et si le visiteur n'a pas deja faire l'authentification
| deuxième route sert à envoyer le nom de l'application que l'employé saisit lors de sa recherche à la méthode chargée de le traiter
| troisième route est utilisé pour executer la méthode qui charge des informations détaillées sur l'application choisie par l'employé
| quatrième route est utilisé pour executer la méthode qui charge les fichiers (application executable, dosumentaton, code source) liés à la version choisie par l'employé
| cinquième route est utilisé pour executer la méthode qui s'ocupe de telecharger le fichier sélectionnés (application executable, dosumentaton, code source) par l'employé
|
*/
Route::get('/ExploreApp', function () {
    if (Session::has('employeeID')) return (new exploreAppControllers)->loadPageData();
    else return redirect('/');
});
Route::get('/contollers/ExploreApp/SearchApp', [exploreAppControllers::class, 'searchApp']);
Route::get('/contollers/ExploreApp/GetApp/{appCode}', [exploreAppControllers::class, 'getApp']);
Route::get('/contollers/ExploreApp/Version/{appID}', [exploreAppControllers::class, 'getAppFiles']);
Route::get('/contollers/ExploreApp/Download/{path}', [exploreAppControllers::class, 'downloadAttachment'])->where('path', '.*'); // a corriger

/*
|--------------------------------------------------------------------------
| ExploreApi Routes
|--------------------------------------------------------------------------
|
| premier route est utilisé pour executer la méthode qui charge la page "exploreApi" s'il est demandé a travers la methode GET et si le visiteur n'a pas deja faire l'authentification
| deuxième route sert à envoyer le nom de l'API que l'employé saisit lors de sa recherche à la méthode chargée de le traiter
| troisième route est utilisé pour executer la méthode qui charge des informations détaillées sur l'application choisie par l'employé
| quatrième route est utilisé pour executer la méthode qui charge les fichiers (dosumentaton, code source) liés à la version choisie par l'employé
| cinquième route est utilisé pour executer la méthode qui s'ocupe de telecharger le fichier sélectionnés (dosumentaton, code source) par l'employé
|
*/
Route::get('/ExploreApi', function () {
    if (Session::has('employeeID')) return (new exploreApiControllers)->loadPageData();
    else return redirect('/');
});
Route::get('/contollers/ExploreApi/SearchApi', [exploreApiControllers::class, 'searchApi']);
Route::get('/contollers/ExploreApi/GetApi/{apiCode}', [exploreApiControllers::class, 'getApi']);
Route::get('/contollers/ExploreApi/Version/{apiID}', [exploreApiControllers::class, 'getApiFiles']);
Route::get('/contollers/ExploreApi/Download/{path}', [exploreApiControllers::class, 'downloadAttachment'])->where('path', '.*'); // a corriger

/*
|--------------------------------------------------------------------------
| AddApp Routes
|--------------------------------------------------------------------------
|
| premier route est utilisé pour executer la méthode qui charge la page "addApp" s'il est demandé a travers la methode GET et si le visiteur n'a pas deja faire l'authentification et il est un administrateur ou super-admin
| deuxième route sert à demander d'après la méthode concernée de charger tous les codes des applications qui existe dans la base de données
| troisième route est utilisé pour executer la méthode qui charge les informations détaillées de la dernier version de l'application choisie par l'administrateur
| quatrième route est utilisé pour executer la méthode qui traite les informations de la nouvelle application saisie par l'administrateur a fin de la sauvegarder dans la base de données
|
*/
Route::get('/AddApp', function () {
    if (Session::has('employeeID')) {
        if ((Session::get('employeeType') == 'superAdmin') || (Session::get('employeeType') == 'admin')) return (new addAppControllers)->loadPageData();
        else return redirect('/Accueil');
    }else return redirect('/');
});
Route::get('/contollers/getAppCodes', [addAppControllers::class, 'getAppCodes']);
Route::get('/contollers/getAppbyCode/{appCode}', [addAppControllers::class, 'getLastAppVersion']);
Route::post('/contollers/AddApp', [addAppControllers::class, 'addApp']);

/*
|--------------------------------------------------------------------------
| AddApi Routes
|--------------------------------------------------------------------------
|
| premier route est utilisé pour executer la méthode qui charge la page "addApi" s'il est demandé a travers la methode GET et si le visiteur n'a pas deja faire l'authentification et il est un administrateur ou super-admin
| deuxième route sert à demander d'après la méthode concernée de charger tous les codes des API qui existe dans la base de données
| troisième route est utilisé pour executer la méthode qui charge les informations détaillées de la dernier version de l'API choisie par l'administrateur
| quatrième route est utilisé pour executer la méthode qui traite les informations de la nouvelle API saisie par l'administrateur a fin de la sauvegarder dans la base de données
|
*/
Route::get('/AddApi', function () {
    if (Session::has('employeeID')) {
        if ((Session::get('employeeType') == 'superAdmin') || (Session::get('employeeType') == 'admin')) return (new addApiControllers)->loadPageData();
        else return redirect('/Accueil');
    }else return redirect('/');
});
Route::post('/contollers/AddApi', [addApiControllers::class, 'addApi']);
Route::get('/contollers/getApibyCode/{apiCode}', [addApiControllers::class, 'getLastApiVersion']);
Route::get('/contollers/getApiCodes', [addApiControllers::class, 'getApiCodes']);

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| premier route est utilisé pour executer la méthode qui charge la page "dashBoard" s'il est demandé a travers la methode GET et si le visiteur n'a pas deja faire l'authentification et il est un super-admin
| deuxième route est utilisée pour demander que l'element spécifié soit supprimé de la base de données en appelant la méthode correspondante
| troisième route est utilisée pour demander que l'element saisi soit ajouté dans la base de données en appelant la méthode correspondante
| quatrième route est utilisée pour executer la méthode qui supprime des administrateurs
| cinquième route demande a la méthode concenée de charger tous les employés qui existent dans la base de donnés afin de promouvoir certains d'entre eux au rend d'administrateur
| sixième route est utilisée pour executer la méthode qui ajoute des nouveaux administrateurs
| septième route est utilisé pour executer la méthode qui charge les informations détaillées de la dernier version de l'application choisie par le super -admin afin de la modifier
| huitième route est utilisé pour executer la méthode qui charge les informations détaillées de la dernier version de l'API choisie par le super -admin afin de la modifier
| neuvième route est utilisé pour executer la méthode qui traite les informations de l'application modifiée saisie par le super-admin a fin de sauvegarder ces modification dans la base de données
| dixième route est utilisé pour executer la méthode qui traite les informations de l'API modifiée saisie par le super-admin a fin de sauvegarder ces modification dans la base de données
|
*/
Route::get('/Dashboard', function (){
    if (Session::has('employeeID')) {
        if (Session::get('employeeType') == 'superAdmin') return (new dashBoardControllers)->loadPageData();
        else return redirect('/Accueil');
    }else return redirect('/');
});
Route::get('/contollers/Dashboard/delete/{tableName}/{keyName}/{rowID}', [dashBoardControllers::class, 'deleteRow']);
Route::get('/contollers/Dashboard/add/{tableName}/{keyName}/{newRow}', [dashBoardControllers::class, 'addRow']);
Route::get('/contollers/Dashboard/delAdmin/{adminID}', [dashBoardControllers::class, 'delAdmin']);
Route::get('/contollers/Dashboard/getEmp', [dashBoardControllers::class, 'getEmp']);
Route::post('/contollers/Dashboard/addAdmins', [dashBoardControllers::class, 'addAdmins']);
Route::get('/contollers/Dashboard/getLastApp/{appID}', [dashBoardControllers::class, 'getLastApp']);
Route::get('/contollers/Dashboard/getLastApi/{apiID}', [dashBoardControllers::class, 'getLastApi']);
Route::post('/contollers/Dashboard/editApp', [dashBoardControllers::class, 'editApp']);
Route::post('/contollers/Dashboard/editApi', [dashBoardControllers::class, 'editApi']);

/*
|
| ce route est utilisée pour executer la méthode qui se charge pour stocker les fichiers des applications et des API (application executable, documentation et code source) dans le chemin aproprié
|
*/
Route::post('file-upload/upload-large-files', [RecieverBigFiles::class, 'uploadLargeFiles']);