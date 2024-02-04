var app = angular.module("loginModule", []);

app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[{');
    $interpolateProvider.endSymbol('}]');
});

app.controller("loginCtrl", ['$scope', '$http', function ($scope, $http) {
/**
 * Ces deux variables ont besoin des valeurs initiales. 
 * Ces deux variables concernes l'affichage le masquage du mot de passe.
 * Initialement input est de type (password) et l'icon montre que l'oeil est visible.
 */
    $scope.pswdVisibility = 'password';
    $scope.icnType = 'fa-lg fa-solid fa-eye';

/**
 * Cette fontion permet d'afficher ou masquer le mot de passe,
 * En changeant le type de l'input (text/password) et le type d'icon.
 */
    $scope.hidePswd = function () {
        switch ($scope.pswdVisibility) {
            case 'password':
                $scope.pswdVisibility = 'texte';
                $scope.icnType = 'fa-lg fa-solid fa-eye-slash';
                break;
            case 'texte':
                $scope.pswdVisibility = 'password';
                $scope.icnType = 'fa-lg fa-solid fa-eye';
                break;
        }
    }

/**
 * Cette fontion permet de connecter avec le serveur Web en utilisant la technologie AJAX
 * pour verifier l'existance de cet utilisateur celon les données saisies.
 * Si la reponse est vide le système affihce le message retourné par le serveur Web (Identifiant ou mot de passe incorrect)
 * Si le cas contraire l'utilisateur sera rederiger vers la page (/Accueil).
 * En cas d'erreur 404 409 ... il sera afficher dans le console
 */
    $scope.logInBtn = function () {
        if ($scope.userId !== undefined && $scope.userPswd !== undefined) {
            var logIn = {
                "userId": $scope.userId,
                "userPswd": $scope.userPswd
            };
            var postData = 'logInData=' + JSON.stringify(logIn);
            $http({
                method: 'POST',
                url: '/contollers/login',
                data: postData,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).then(function (response) {
                if (response.data === "") {
                    window.location = '/Accueil';
                }else{
                    $scope.logInReply = response.data;
                }
                
            }).catch(function (error) {
                console.log(error);
            });
        }
    }
}]);