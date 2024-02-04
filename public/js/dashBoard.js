var app = angular.module("dashBoardModule", []);

app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[{');
    $interpolateProvider.endSymbol('}]');
});

app.controller("dashBoardCtrl", ['$scope', '$http', function ($scope, $http) {

/**
 * Ces variables ont besoin des valeurs initiales. 
 * (modal1Visibility) concerne l'affichage et le masquage du fenetre qui est responsable
 * sur l'affichage des differents employés.
 * (modal2Visibility) concerne l'affichage et le masquage du fenetre qui est responsable
 * sur la modification de l'application selectionnée.
 * (modal3Visibility) concerne l'affichage et le masquage du fenetre qui est responsable
 * sur la modification de l'API selectionnée. 
 * (appIconDiplay) concerne l'affichage et le masquage du logo de l'application selectionnée
 * pour la modification. 
 * (apiIconDiplay) concerne l'affichage et le masquage du logo de l'application selectionnée
 * pour la modification.
 * Initialement les variables ont la valeur false.
 */
    $scope.modal1Visibility = $scope.modal2Visibility = $scope.modal3Visibility = $scope.appIconDiplay = $scope.apiIconDiplay = false;
    var langArray = [];
    
/**
 * Cette fontion permet de connecter avec le serveur Web en utilisant la technologie AJAX,
 * Le système retourne la liste de tous les employés qui existe dans la base de données.
 * En cas d'erreur 404 409 ... il sera afficher dans le console
 */
    $scope.openModal1 = function() {
        $http({
            method: 'get',
            url: '/contollers/Dashboard/getEmp'
        }).then(function successCallback(response) {
            $scope.employees = response.data;
        }).catch(function (error) {
            console.log(error);
        });
        $scope.modal1Visibility = true;
    }

/**
 * Cette fontion permet de masquer la fenetre où il y a la liste des employés et renitialiser la liste.
 */
    $scope.closeModal1 = function () {
        $scope.modal1Visibility = false;
        $scope.employees = null;
    }


/**
 * Cette fontion permet de connecter avec le serveur Web en utilisant la technologie AJAX,
 * Elle envoie l'identifiant de l'application selectionnée par l'employé et le système retourne les informations
 * de la derniere version de cette application et les langages utilisés.
 * La fonction se charge d'enregistrer les differentes informations dans la reponse dans les champs correctes.
 * En cas d'erreur 404 409 ... il sera afficher dans le console
 */
    $scope.openModal2 = function(event) {
        appID = event.currentTarget.id;
        $http({
            method: 'get',
            url: '/contollers/Dashboard/getLastApp/' + appID
        }).then(function successCallback(response) {
            App = response.data[0];
            document.getElementById("appID").value = App.appID;
            $scope.appCode = App.appCode;
            $scope.appName = App.appName;
            $scope.appVersion = App.version;
            $scope.appAdmin = App.employeeName;
            $scope.appDescription = App.description;
            $scope.appIcon = document.getElementById("OldAppImage").value = App.appIcon;
            document.getElementById("OldAppDocument").value = App.documentation;
            document.getElementById('AppStatus').value = App.status;
            document.getElementById('AppDept').value = App.department;
            document.getElementById('AppServ').value = App.service;
            document.getElementById('AppEditor').value = App.editor;
            document.getElementById('AppTSlt').value = App.solutionType;
            document.getElementById('AppTApp').value = App.applicationType;
            document.getElementById('AppTArcht').value = App.architectureType;
            document.getElementById('AppPtf').value = App.platform;
            document.getElementById('AppDB').value = App.dataBase;
            document.getElementById('AppMW').value = App.middleware;

            for (let index = 1; index < response.data.length; index++) {
                if ('appCoderAssociationID' in response.data[index]){
                    langArray.push(response.data[index]);
                    varID = 'appLang' + response.data[index].languageFK;
                    document.getElementById(varID).checked = true;
                }
            }
        }).catch(function (error) {
            console.log(error.message);
        });
        $scope.appIconDiplay = true;
        $scope.modal2Visibility = true;
    }

/**
 * Cette fontion permet de masquer la fenetre où le super-admin peut modifier les informations 
 * de l'application deja selectionnée et renitialiser les champs pour les mettre valable 
 * pour les informations de la nouvelle application qui sera selectionner.
 */
    $scope.closeModal2 = function () {
        $scope.modal2Visibility = $scope.appIconDiplay = false;
        langArray = [];
        $scope.appCode = $scope.appName = $scope.appVersion = $scope.appAdmin = $scope.appDescription = $scope.appIcon = null;
        var inputs = document.querySelectorAll('.appLangCheck');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].checked = false;
        }
    }


/**
 * Cette fontion permet de connecter avec le serveur Web en utilisant la technologie AJAX,
 * Elle envoie l'identifiant de l'API selectionnée par l'employé et le système retourne les informations
 * de la derniere version de cette API et les langages utilisés.
 * La fonction se charge d'enregistrer les differentes informations dans la reponse dans les champs correctes.
 * En cas d'erreur 404 409 ... il sera afficher dans le console
 */
    $scope.openModal3 = function(event) {
        apiID = event.currentTarget.id;
        $http({
            method: 'get',
            url: '/contollers/Dashboard/getLastApi/' + apiID
        }).then(function successCallback(response) {
            Api = response.data[0];
            document.getElementById("apiID").value = Api.apiID;
            $scope.apiCode = Api.apiCode;
            $scope.apiName = Api.apiName;
            $scope.apiVersion = Api.version;
            $scope.apiAdmin = Api.employeeName;
            $scope.apiDescription = Api.description;
            $scope.apiIcon = document.getElementById("OldApiImage").value = Api.apiIcon;
            document.getElementById("OldApiDocument").value = Api.documentation;
            document.querySelector('input[value=' + Api.secutity + ']').checked = true;
            document.getElementById('ApiStatus').value = Api.status;
            document.getElementById('ApiDept').value = Api.department;
            document.getElementById('ApiServ').value = Api.service;
            document.getElementById('ApiEditor').value = Api.editor;
            document.getElementById('ApiType').selectedIndex = Api.apiType;
            document.getElementById('ApiResponse').selectedIndex = Api.apiResponse;
            document.getElementById('ApiDB').value = Api.dataBase;
            document.getElementById('ApiMW').value = Api.middleware;
            for (let index = 1; index < response.data.length; index++) {
                if ('apiCoderAssociationID' in response.data[index]){
                    langArray.push(response.data[index]);
                    varID = 'apiLang' + response.data[index].languageFK;
                    document.getElementById(varID).checked = true;
                }
            }
        }).catch(function (error) {
            console.log(error.nessage);
        });
        $scope.apiIconDiplay = true;
        $scope.modal3Visibility = true;
    }

/**
 * Cette fontion permet de masquer la fenetre où le super-admin peut modifier les informations 
 * de l'API deja selectionnée et renitialiser les champs pour les mettre valable 
 * pour les informations de la nouvelle application qui sera selectionner.
 */
    $scope.closeModal3 = function () {
        $scope.modal3Visibility = $scope.apiIconDiplay = false;
        langArray = [];
        $scope.apiCode = $scope.apiName = $scope.apiVersion = $scope.apiAdmin = $scope.apiDescription = $scope.apiIcon = null;
        var inputs = document.querySelectorAll('.apiLangCheck');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].checked = false;
        }
    }
    
/**
 * Cette fontion permet de connecter avec le serveur Web en utilisant la technologie AJAX,
 * Elle envoie le nom du nouveau element, le nom du table où il sera ajouter et le nom du colonne 
 * et le système retourne un message d'erreur s'il n'a pas put d'ajouter cet element (existe déjà).
 * Si le cas contraire le systeme ajoute correctement l'element et recharger la page une autre fois.
 * En cas d'erreur 404 409 ... il sera afficher dans le console
 */
    $scope.addRow = function (rowContent, tableName, columnName) {
        if (rowContent !== undefined && tableName !== undefined && columnName !== undefined) {
            $http({
                method: 'get',
                url: '/contollers/Dashboard/add/' + tableName + '/' + columnName + '/' + rowContent
            }).then(function successCallback(response) {
                if (response.data == 0) {
                    alert('existe déjà');
                } else {
                    window.location = '/Dashboard';
                }
            }).catch(function (error) {
                console.log(error);
            });
        }
        else{
            alert('Remplir le champ');
        }
    }

/**
 * Cette fonction concerne l'affichage de l'image choisissée par le super-admin avant la confirmation de l'operation.
 */
    $scope.SelectImg = function (e) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $scope.apiIconDiplay = $scope.appIconDiplay = true;
            $scope.appIcon = $scope.apiIcon = e.target.result;
            $scope.$apply();
        };
        reader.readAsDataURL(e.target.files[0]);
    };

/**
 * Cette fonction concerne la suppression de l'image choisissée par le super-admin avant la confirmation de l'operation.
 */
    $scope.delImg = function (kind) {
        document.getElementById(kind + 'UploadImg').value = null;
        $scope.apiIcon = $scope.appIcon = null;
        $scope.apiIconDiplay = $scope.appIconDiplay = false;
    }
}]);