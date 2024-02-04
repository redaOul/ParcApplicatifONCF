<!DOCTYPE html>
<html lang="en" ng-app="loginModule">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="shortcut icon" href="/icon/ONCForiginal.svg">
        <link rel="stylesheet" href="/css/Login_style.css">
        <link rel="stylesheet" href="/FAicons/css/all.css">
    </head>
    <body ng-controller="loginCtrl">
        <main>
            <div id="form">
                {{-- la section où le visiteur peut inserer son nom d'utilisateur et mot de passe --}}
                <span>
                    <i class="fa-solid fa-user fa-lg"></i>
                    <input type="text" placeholder="Nom d'utilisateur" ng-model="userId" required>
                </span>
                <span>
                    <i class="fa-solid fa-lock fa-lg"></i>
                    <input type="[{pswdVisibility}]" placeholder="Mot de passe" id="passwordInput" ng-model="userPswd" required>
                    <i class="[{icnType}]" ng-click="hidePswd()" id="passwordIcon"></i>
                </span>
                <button ng-click="logInBtn()">Connexion</button>
                {{-- la section où le message d'erreur s'affiche --}}
                <div id="loginReply">[{logInReply}]</div>
            </div>
        </main>

        <script src="/js/angular/angular.min.js"></script>
        <script src="/js/login.js"></script>
    </body>
</html>