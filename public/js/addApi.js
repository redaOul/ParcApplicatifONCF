var app = angular.module("addAApi", []);

app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[{');
    $interpolateProvider.endSymbol('}]');
});

app.controller("addApiCtrl", ['$scope', '$http', function ($scope, $http) {

/**
 * (imgDiplay) concerne l'affichage et le masquage du logo de l'API.
 */
    $scope.imgDiplay = false;

/**
 * Cette fontion permet de connecter avec le serveur Web en utilisant la technologie AJAX,
 * Le système retourne tous les codes des APIs qui existe.
 * En cas d'erreur 404 409 ... il sera afficher dans le console
 *******************************************************************************************
 * La raison de faire charger les codes des APIs d'apres ajax et non directement 
 * d'après le serveur Web. pour avoir la possibilite de recuperer ces codes dans un tableau 
 * indipendant. Après le tableau sera utilisé en cas d'ajout d'une nouvelle API. Cela 
 * nous aidera à empêcher l'administrateur d'ajouter une nouvelle API avec un code précédemment utilisé.
 * Jusqu'à présent, je n'ai pas pu activer cette fonctionnalité car le système ne peut pas 
 * connaître les valeurs de la table en dehors du scope (codeArray)
 */
    $http({
        method: 'get',
        url: '/contollers/getApiCodes'
    }).then(function successCallback(response) {
        $scope.apiCodesScope = codeArray = response.data;
        // codeArray est non définie en dehors du ce scope
    });
    
/**
 * Cette fonction concerne l'affichage de l'image choisissée par l'administrateur avant la confirmation de l'operation.
 */
    $scope.SelectImg = function (e) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $scope.imgDiplay = true;
            $scope.PreviewImage = e.target.result;
            $scope.$apply();
        };
        reader.readAsDataURL(e.target.files[0]);
    };

/**
 * Cette fonction concerne la suppression de l'image choisissée par l'administrateur avant la confirmation de l'operation.
 */
    $scope.delImg = function () {
        document.getElementById("uploadImg").value = null;
        $scope.PreviewImage = null;
        $scope.imgDiplay = false;
    }

/**
 * Cette fontion permet renitialiser les champs pour les mettre valable 
 * pour l'ajout de la nouvelle API.
 */
    $scope.newApi = function () {
        $scope.codeInput = $scope.nomInput = $scope.versionInput = $scope.descirptionInput = null;
        document.getElementById("docPath").value = null;
        document.getElementById("scPath").value = null;

        document.getElementsByName('ApiCode')[0].readOnly = false;
        $scope.delImg();
        $scope.checkLang = false;

        $scope.LastApiCode = "";
        document.getElementById('ApiStatus').selectedIndex = 0;
        document.getElementById('ApiDept').selectedIndex = 0;
        document.getElementById('ApiServ').selectedIndex = 0;
        document.getElementById('ApiEditor').selectedIndex = 0;
        document.getElementById('secYes').checked = true;
        document.getElementById('ApiType').selectedIndex = 0;
        document.getElementById('ApiResponse').selectedIndex = 0;
        document.getElementById('ApiDB').selectedIndex = 0;
        document.getElementById('ApiMW').selectedIndex = 0;
    }

/**
 * Cette fontion permet de connecter avec le serveur Web en utilisant la technologie AJAX,
 * Elle envoie le code de l'API selectionnée par l'employé et le système retourne les informations
 * de la derniere version de cette API et les langages utilisés.
 * La fonction se charge d'enregistrer les differentes informations dans la reponse dans les champs correctes.
 * En cas d'erreur 404 409 ... il sera afficher dans le console.
 *******************************************************************************************
 * la fonctionnalitée: (empêcher l'administrateur d'inserer un nombre de version inferieur a celui de la dernier version existe) n'est pas realisée.
 * La raison c'est que je n'ai pas put recuperer la dernier version dans une variable globale et la reutiliser
 * dans la fonction qui fait ce traitement (undefined)
 */
    $scope.selectApi = function(){
        if ($scope.LastApiCode !== null) {
            $http({
                method: 'get',
                url: '/contollers/getApibyCode/' + $scope.LastApiCode
            }).then(function successCallback(response) {
                var Api = response.data[0];
                $scope.codeInput = Api.apiCode;
                $scope.nomInput = Api.apiName;
                $scope.versionInput = Api.version;
                $scope.descirptionInput = Api.description;

                document.getElementById("docPath").value = Api.documentation;
    
                document.getElementsByName('ApiCode')[0].readOnly = true;
    
                document.querySelector('input[value=' + Api.secutity + ']').checked = true;
                document.getElementById('ApiStatus').value = Api.status;
                document.getElementById('ApiDept').value = Api.department;
                document.getElementById('ApiServ').value = Api.service;
                document.getElementById('ApiEditor').value = Api.editor;
                document.getElementById('ApiType').selectedIndex = Api.apiType;
                document.getElementById('ApiResponse').selectedIndex = Api.apiResponse;
                document.getElementById('ApiDB').value = Api.dataBase;
                document.getElementById('ApiMW').value = Api.middleware;
            }).catch(function (error) {
                console.log(error);
            });
        }
    }
}]);

/**
 * c'est la fonction qui permet de verifier si le nombre de la nouvelle version est superieur que l'ancienne
 */
// $scope.checkversion = function(){
//     newVer = $scope.versionInput;
//     oldVer = version;
//     newArrVer = newVer.split('.'),
//     oldArrVer = oldVer.split('.');
//     while (newArrVer.length < oldArrVer.length) newArrVer.push("0");
//     while (oldArrVer.length < newArrVer.length) oldArrVer.push("0");
//     console.log('newArrVer: ' + newArrVer + " === oldArrVer: " + oldArrVer);
//     returnedValue = "false";
//     for (var i = 0; i < newArrVer.length; ++i) {
//         if (newArrVer[i] == oldArrVer[i]) {
//             console.log('newArrVer: ' + newArrVer[i] + " = oldArrVer: " + oldArrVer[i] + " => i: " + i);
//             continue;
//         }
//         else if (oldArrVer[i] > newArrVer[i]) {
//             console.log('newArrVer: ' + newArrVer[i] + " < oldArrVer: " + oldArrVer[i] + " => i: " + i);
//             returnedValue = "true";
//             console.log(returnedValue);
//             if (returnedValue == "true") {
//                 alert('tiit');
//                 break;
//             }
//         }
//     }
//     if (returnedValue == "true") {
//         alert('inserez une version plus grande');
//     }
// }



/**
 * cette section du code est reservée pour le telechargement des fichiers massives
 * en utilisant la bibliothéque ResumableJS et a la fin le syteme stock le chemin de ces fichiers dans des inputs
 * pour les stocker aprés dans la base de données.
 * Une API l'administrateur doit telecharger 2 fichiers (documentation et code source)
 * pour ça on a le traitement du 3 objets (resumableDoc, resumableSC)
 */

    var Documentation = document.getElementById("Documentation");
    var SourceCode = document.getElementById("SourceCode");
    var docPath = document.getElementById("docPath");
    var scPath = document.getElementById("scPath");
    var uploadBarMmodal = document.getElementById("uploadBarMmodal");
    var progressBar = document.getElementById("progressBar");
    var progressValue = document.getElementById("progressValue");
    var csrfToken = document.querySelector('meta[name="_token"]').content;
    
    // Upload documentation
    let resumableDoc = new Resumable({
        target: '/file-upload/upload-large-files',
        query:{ 
            _token: csrfToken,
            storagePath: 'Api/Documentation'
        },
        fileType: ['pdf'],
        headers: { 'Accept' : 'application/json' },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });
    resumableDoc.assignBrowse(Documentation);
    resumableDoc.on('fileAdded', function (file) {
        showProgress();
        resumableDoc.upload();
    });
    resumableDoc.on('fileProgress', function (file) {
        updateProgress(Math.floor(file.progress() * 100));
    });
    resumableDoc.on('fileSuccess', function (file, response) {
        hideProgress(docPath, JSON.parse(response).path);
    });
    resumableDoc.on('fileError', function (file, response) {
        uploadBarMmodal.style.display = 'none';
        alert('Erreur lors du téléchargement');
    });

    // Upload code source
    let resumableSC = new Resumable({
        target: '/file-upload/upload-large-files',
        query:{ 
            _token: csrfToken,
            storagePath: 'Api/SourceCode'
        },
        fileType: ['zip', 'rar', '7z'],
        headers: { 'Accept' : 'application/json' },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });
    resumableSC.assignBrowse(SourceCode);
    resumableSC.on('fileAdded', function (file) {
        showProgress();
        resumableSC.upload();
    });
    resumableSC.on('fileProgress', function (file) {
        updateProgress(Math.floor(file.progress() * 100));
    });
    resumableSC.on('fileSuccess', function (file, response) {
        hideProgress(scPath, JSON.parse(response).path);
    });
    resumableSC.on('fileError', function (file, response) {
        uploadBarMmodal.style.display = 'none';
        alert('Erreur lors du téléchargement');
    });
    
    
    function showProgress() {
        progressBar.setAttribute("value", 0);
        progressValue.innerHTML = '0%';
        uploadBarMmodal.style.display = 'initial';
    }
    function updateProgress(value) {
        progressBar.setAttribute("value", value);
        progressValue.innerHTML = value + '%';
    }
    function hideProgress(selector, target) {
        selector.value = target;
        uploadBarMmodal.style.display = 'none';
    }
