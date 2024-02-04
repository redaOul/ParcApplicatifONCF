var app = angular.module("addApp", []);

app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[{');
    $interpolateProvider.endSymbol('}]');
});

app.controller("addAppCtrl", ['$scope', '$http', function ($scope, $http) {

/**
 * Ces variables ont besoin des valeurs initiales. 
 * (inputType) permet de changer le type input (soit un lien soit un fichier pour application executable).
 * (displayInput) permet concerne l'affichage et le masquage du fenetre qui est responsable
 * sur la modification de l'application selectionnée.
 * (displayIcon) concerne l'affichage et le masquage input pour saisir le lien ou saisir le chemin de l'application telechargée.
 */
    $scope.inputType = 'url';
    $scope.displayInput = true;
    $scope.displayIcon = false;

/**
 * Cette fontion permet de connecter avec le serveur Web en utilisant la technologie AJAX,
 * Le système retourne tous les codes des applications qui existe.
 * En cas d'erreur 404 409 ... il sera afficher dans le console
 *******************************************************************************************
 * La raison de faire charger les codes des applications d'apres ajax et non directement 
 * d'après le serveur Web. pour avoir la possibilite de recuperer ces codes dans un tableau 
 * indipendant. Après le tableau sera utilisé en cas d'ajout d'une nouvelle application. Cela 
 * nous aidera à empêcher l'administrateur d'ajouter une nouvelle application avec un code précédemment utilisé.
 * Jusqu'à présent, je n'ai pas pu activer cette fonctionnalité car le système ne peut pas 
 * connaître les valeurs de la table en dehors du scope (codeArray)
 */
    $http({
        method: 'get',
        url: '/contollers/getAppCodes'
    }).then(function successCallback(response) {
        $scope.appCodesScope = codeArray = response.data;
        // codeArray est non définie en dehors du ce scope
    });
    
/**
 * Cette fontion permet de basculer entre le saisi d'un lien ou l'ajout d'un fichier executable.
 * pour l'ajout d'un fichier executable, le fichier est telechargé d'aprés une autre technique
 * et le chemin de ce fichier sera stocker dans input de type text et il va etre masqué
 * pour le stocker après dans la base de données.
 */
    $scope.radioType = function (radioType) {
        switch (radioType) {
            case 'url':
                $scope.inputType = radioType;
                $scope.displayInput = true;
                $scope.aeInput = null;
                $scope.displayIcon = false;
                break;
            case 'text':
                $scope.inputType = radioType;
                $scope.displayInput = false;
                $scope.aeInput = null;
                $scope.displayIcon = true;
                break;
        }
    };

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
 * pour l'ajout de la nouvelle application.
 */
    $scope.newApp = function () {
        $scope.codeInput = $scope.nomInput = $scope.versionInput = $scope.descirptionInput = null;
        document.getElementById("docPath").value = null;
        document.getElementById("scPath").value = null;
        document.getElementById("aePath").value = null;

        document.getElementsByName('AppCode')[0].readOnly = false;
        $scope.delImg();
        $scope.checkLang = false;

        $scope.LastAppCode = "";
        document.getElementById('AppStatus').selectedIndex = 0;
        document.getElementById('AppDept').selectedIndex = 0;
        document.getElementById('AppServ').selectedIndex = 0;
        document.getElementById('AppEditor').selectedIndex = 0;
        document.getElementById('AppTSlt').selectedIndex = 0;
        document.getElementById('AppTApp').selectedIndex = 0;
        document.getElementById('AppTArcht').selectedIndex = 0;
        document.getElementById('AppPtf').selectedIndex = 0;
        document.getElementById('AppDB').selectedIndex = 0;
        document.getElementById('AppMW').selectedIndex = 0;
    }

/**
 * Cette fontion permet de connecter avec le serveur Web en utilisant la technologie AJAX,
 * Elle envoie le code de l'application selectionnée par l'employé et le système retourne les informations
 * de la derniere version de cette application et les langages utilisés.
 * La fonction se charge d'enregistrer les differentes informations dans la reponse dans les champs correctes.
 * En cas d'erreur 404 409 ... il sera afficher dans le console.
 *******************************************************************************************
 * la fonctionnalitée: (empêcher l'administrateur d'inserer un nombre de version inferieur a celui de la dernier version existe) n'est pas realisée.
 * La raison c'est que je n'ai pas put recuperer la dernier version dans une variable globale et la reutiliser
 * dans la fonction qui fait ce traitement (undefined)
 */
    $scope.selectApp = function(){
        if ($scope.LastAppCode !== null) {
            $http({
                method: 'get',
                url: '/contollers/getAppbyCode/' + $scope.LastAppCode
            }).then(function successCallback(response) {
                var App = response.data[0];
                $scope.codeInput = App.appCode;
                $scope.nomInput = App.appName;
                $scope.versionInput = App.version;
                $scope.descirptionInput = App.description;
                
                document.getElementById("docPath").value = App.documentation;
    
                document.getElementsByName('AppCode')[0].readOnly = true;
    
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
 * Une application l'administrateur doit telecharger 3 fichiers (application executable, documentation et code source)
 * pour ça on a le traitement du 3 objets (resumableDoc, resumableSC et resumableExe)
 */

var Documentation = document.getElementById("Documentation");
var SourceCode = document.getElementById("SourceCode");
var AppExecutable = document.getElementById("AppExecutable");
var docPath = document.getElementById("docPath");
var scPath = document.getElementById("scPath");
var aePath = document.getElementById("aePath");
var uploadBarMmodal = document.getElementById("uploadBarMmodal");
var progressBar = document.getElementById("progressBar");
var progressValue = document.getElementById("progressValue");
var csrfToken = document.querySelector('meta[name="_token"]').content;

// Upload documentation
let resumableDoc = new Resumable({
    target: '/file-upload/upload-large-files',
    query:{ 
        _token: csrfToken,
        storagePath: 'App/Documentation'
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
        storagePath: 'App/SourceCode'
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

// Upload application executable
let resumableExe = new Resumable({
    target: '/file-upload/upload-large-files',
    query:{ 
        _token: csrfToken,
        storagePath: 'App/ExecutableApp'
    },
    fileType: ['zip', 'rar', '7z'],
    headers: { 'Accept' : 'application/json' },
    testChunks: false,
    throttleProgressCallbacks: 1,
});
resumableExe.assignBrowse(AppExecutable);
resumableExe.on('fileAdded', function (file) {
    showProgress();
    resumableExe.upload();
});
resumableExe.on('fileProgress', function (file) {
    updateProgress(Math.floor(file.progress() * 100));
});
resumableExe.on('fileSuccess', function (file, response) {
    hideProgress(aePath, JSON.parse(response).path);
});
resumableExe.on('fileError', function (file, response) {
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