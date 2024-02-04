var app = angular.module("exploreItems", []);

app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[{');
    $interpolateProvider.endSymbol('}]');
});

app.controller("exploreApp", ['$scope', '$http', function ($scope, $http) {

/**
 * Ces deux variables ont besoin des valeurs initiales. 
 * (modalVisibility) concerne l'affichage et le masquage du fenetre qui est responsable
 * sur l'affichage des informations de l'application selectionnée.
 * (disableBtn) concerne l'affichage des boutons pour telecharger les fichiers 
 * d'une application (application executable, documentation et code source) jusqu'a l'employé specifie la version.
 * Initialement les deux variables sont la valeur false.
 */
    $scope.modalVisibility = $scope.disableBtn = false;
    $scope.appImgSrc = '';
    
/**
 * Cette fontion permet de connecter avec le serveur Web en utilisant la technologie AJAX,
 * Elle envoie le code de l'application selectionnée par l'employé et le système retourne les informations
 * de la derniere version de cette application, les langages utilisés et les nombres des differents versions.
 * La fonction se charge d'enregistrer les differentes informations dans la reponse dans les champs correctes.
 * En cas d'erreur 404 409 ... il sera afficher dans le console
 */
    $scope.preparemodal = function(event){
        appCode = event.currentTarget.id;
        $http({
            method: 'get',
            url: '/contollers/ExploreApp/GetApp/' + appCode
        }).then(function (response) {
            var langArray = [], verArray = [];
            for (let index = 1; index < response.data.length; index++) {
                if ('languageName' in response.data[index]) langArray.push(response.data[index].languageName);
                else verArray.push(response.data[index]);
            }

            appData = response.data[0];
            $scope.appImgSrc = appData.appIcon;
            $scope.appCode = appData.appCode;
            $scope.appName = appData.appName;
            $scope.appDept = appData.department;
            $scope.appServ = appData.service;
            $scope.appAdmin = appData.employeeName;
            $scope.appEdit = appData.editor;
            /**
             * Changez le type de réponse de string en Date, puis nous spécifions les éléments 
             * que nous voulons conserver lors de l'affichage de la date d'ajout
             */
            $scope.appDate = new Date(appData.created_at.substr(0, 10)).toString().substr(0,15);
            $scope.appStat = appData.status;
            $scope.appSol = appData.solutionType;
            $scope.appTApp = appData.applicationType;
            $scope.appArch = appData.architectureType;
            $scope.appPtf = appData.platform;
            $scope.appDB = appData.dataBase;
            $scope.appMW = appData.middleware;
            $scope.appDesc = appData.description;
            
            $scope.appLang = langArray.join(', ');

            $scope.VersionS = verArray;
            
        }).catch(function (error) {
            console.log(error);
        });
        $scope.modalVisibility = true;
    }
    
/**
 * Cette fontion permet de connecter avec le serveur Web en utilisant la technologie AJAX,
 * Elle envoie l'identifiant de la version de l'application selectionnée par l'employé et le système retourne les fichiers
 * (application executable, documentation et code source) apropriés a la version selectionnée.
 * La fonction se charge d'enregistrer les differentes informations dans la reponse dans les champs correctes.
 * En cas d'erreur 404 409 ... il sera afficher dans le console
 */
    $scope.selectVersion = function(){
        if ($scope.appIde !== null) {
            $http({
                method: 'get',
                url: '/contollers/ExploreApp/Version/' + $scope.appIde
            }).then(function (response) {
                $scope.Docpath = response.data.documentation;
                $scope.SCpath = response.data.sourceCode;

                if (isValidUrl(response.data.appExe)) $scope.Exepath = response.data.appExe;
                else $scope.Exepath = '/contollers/ExploreApp/Download' + response.data.appExe;
                
                $scope.disableBtn = true;
            }).catch(function (error) {
                console.log(error);
            });
        }
    }

/**
 * Cette fontion permet de masquer la fenetre où les informations detailées d'une application deja selectionnée
 * et renitialiser les champs pour les mettre valable pour les informations de la nouvelle application
 * qui sera selectionner.
 */
    $scope.closeModal = function () {
        $scope.modalVisibility = false;
        $scope.disableBtn = false;
        
        $scope.appImgSrc = $scope.appCode = $scope.appName = $scope.appDept = $scope.appServ = $scope.appAdmin = null;
        $scope.appEdit = $scope.appDate = $scope.appStat = $scope.appSol = $scope.appTApp = $scope.appArch = null;
        $scope.appPtf = $scope.appDB = $scope.appMW = $scope.appDesc = $scope.appLang = $scope.VersionS = null;
        $scope.Docpath = $scope.SCpath = $scope.Exepath = null
    }
}]);

app.controller("exploreApi", ['$scope', '$http', function ($scope, $http) {

/**
 * Ces deux variables ont besoin des valeurs initiales. 
 * (modalVisibility) concerne l'affichage et le masquage du fenetre qui est responsable
 * sur l'affichage des informations de l'API selectionnée.
 * (disableBtn) concerne l'affichage des boutons pour telecharger les fichiers 
 * d'une API (documentation et code source) jusqu'a l'employé specifie la version.
 * Initialement les deux variables ont la valeur false.
 */
    $scope.modalVisibility = $scope.disableBtn = false;
    $scope.apiImgSrc = '';
    
/**
 * Cette fontion permet de connecter avec le serveur Web en utilisant la technologie AJAX,
 * Elle envoie le code de l'API selectionnée par l'employé et le système retourne les informations
 * de la derniere version de cette API, les langages utilisés et les nombres des differents versions.
 * La fonction se charge d'enregistrer les differentes informations dans la reponse dans les champs correctes.
 * En cas d'erreur 404 409 ... il sera afficher dans le console
 */
    $scope.preparemodal = function(event){
        apiCode = event.currentTarget.id;
        $http({
            method: 'get',
            url: '/contollers/ExploreApi/GetApi/' + apiCode
        }).then(function (response) {
            var langArray = [], verArray = [];
            for (let index = 1; index < response.data.length; index++) {
                if ('languageName' in response.data[index])  langArray.push(response.data[index].languageName);
                else verArray.push(response.data[index]);
            }

            apiData = response.data[0];
            $scope.apiImgSrc = apiData.apiIcon;
            $scope.apiCode = apiData.apiCode;
            $scope.apiName = apiData.apiName;
            $scope.apiDept = apiData.department;
            $scope.apiServ = apiData.service;
            $scope.apiAdmin = apiData.employeeName;
            $scope.apiEdit = apiData.editor;
            /**
             * Changez le type de réponse de string en Date, puis nous spécifions les éléments 
             * que nous voulons conserver lors de l'affichage de la date d'ajout
             */
            $scope.apiDate = new Date(apiData.created_at.substr(0, 10)).toString().substr(0,15);
            $scope.apiStat = apiData.status;
            $scope.apiSec = apiData.secutity;
            $scope.apiType = apiData.apiType;
            $scope.apiResponse = apiData.apiResponse;
            $scope.apiDB = apiData.dataBase;
            $scope.apiMW = apiData.middleware;
            $scope.apiDesc = apiData.description;

            $scope.apiLang = langArray.join(', ');

            $scope.VersionS = verArray;

        }).catch(function (error) {
            console.log(error);
        });
        $scope.modalVisibility = true;
    }
        
/**
 * Cette fontion permet de connecter avec le serveur Web en utilisant la technologie AJAX,
 * Elle envoie l'identifiant de la version de l'API selectionnée par l'employé et le système retourne les fichiers
 * (documentation et code source) apropriés a la version selectionnée.
 * La fonction se charge d'enregistrer les differentes informations dans la reponse dans les champs correctes.
 * En cas d'erreur 404 409 ... il sera afficher dans le console
 */
    $scope.selectVersion = function(){
        if ($scope.apiIde !== null) {
            $http({
                method: 'get',
                url: '/contollers/ExploreApi/Version/' + $scope.apiIde
            }).then(function (response) {
                $scope.Docpath = response.data.documentation;
                $scope.SCpath = response.data.sourceCode;
                
                $scope.disableBtn = true;
            }).catch(function (error) {
                console.log(error);
            });
        }
    }

/**
 * Cette fontion permet de masquer la fenetre où les informations detailées d'une API deja selectionnée
 * et renitialiser les champs pour les mettre valable pour les informations de la nouvelle API
 * qui sera selectionner.
 */
    $scope.closeModal = function () {
        $scope.modalVisibility = false;
        $scope.disableBtn = false;

        $scope.apiImgSrc = $scope.apiCode = $scope.apiName = $scope.apiDept = $scope.apiServ = $scope.apiAdmin = null;
        $scope.apiEdit = $scope.apiDate = $scope.apiStat = $scope.apiSec = $scope.apiType = $scope.apiResponse = null;
        $scope.apiDB = $scope.apiMW = $scope.apiDesc = $scope.apiLang = $scope.VersionS = $scope.Docpath = $scope.SCpath = null;
    }
}]);

/**
 * Cette fonction retourne true si le parametre passé est un lien. Si le cas contraire retourne false
 * Cette fonction permet de fer la difference entre est ce que l'application executable est un lien 
 * vers un store (appStore / playStore) ou un fichier compressé
 */
function isValidUrl(_string) {
    let url_string; 
    try {
        url_string = new URL(_string);
    } catch (_) {
        return false;  
    }
    return url_string.protocol === "http:" || url_string.protocol === "https:" ;
}