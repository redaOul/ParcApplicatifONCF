<!DOCTYPE html>
<html lang="en" ng-app="exploreItems">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore APPs</title>
    <link rel="shortcut icon" href="/icon/ONCForiginal.svg" />
    <link rel="stylesheet" href="/FAicons/css/all.css">
    <link rel="stylesheet" href="/css/ExploreApp_style.css">
    <link rel="stylesheet" href="/css/navHeader_style.css">
</head>

<body ng-controller="exploreApp">
    @include('navHeader')
    <div id="rightSide">
        <main>
            {{-- la section pour chercher une application par le nom --}}
            <form method="get" action="/contollers/ExploreApp/SearchApp" id="haidContainer">
                <input type="text" name="appName" placeholder="Chercher içi...">
                <button type="submit" class="fa-solid fa-magnifying-glass fa-2xl"></button>
            </form>
            
            @foreach ($apps as $app) 
            <article id="{{ $app->appCode }}" data-ng-click="preparemodal($event)">
                <div class="imgContainer">
                    <img src="{{$app->appIcon}}" alt="Logo Img">
                </div>
                <div class="infoContainer">
                    <h1>{{$app->appCode . " - " . $app->appName}}</h1>
                    <table>
                        <tr>
                            <td>Departement: {{$app->department}}</td>
                            <td>Service: {{$app->service}}</td>
                        </tr>
                        <tr>
                            <td>Admin: {{$app->employeeName}}</td>
                            <td>Editeur: {{$app->editor}}</td>
                        </tr>
                        <tr>
                            <td>Type de solution: {{$app->solutionType}}</td>
                            <td>Type d'application: {{$app->applicationType}}</td>
                        </tr>
                    </table>
                    <div>Description</div>
                    <p>{{$app->description}}</p>
                </div>
            </article>
            @endforeach

            {{-- la section pour afficher les informations detaillées de l'application selectionnée --}}
            <div id="detailsAppMmodal" ng-show="modalVisibility">
                <div id="modelContainer">
                    <div id="backIcon" class="fa-solid fa-arrow-left-long" ng-click="closeModal()"></div>
                    <div id="contentContainer">
                        <div id="imgContainer">
                            <img src="[{appImgSrc}]" alt="Logo Img">
                        </div>
                        <div id="infoContainer">
                            <h1>[{appCode}] - [{appName}]</h1>
                            <div id="gridContainer">
                                <div class="items" style="grid-area: 1 / 1 / span 1 / span 3">
                                    Departement: [{appDept}]
                                </div>
                                <div class="items" style="grid-area: 1 / 4 / span 1 / span 3">
                                    Service: [{appServ}]
                                </div>
                                <div class="items" style="grid-area: 2 / 1 / span 1 / span 3">
                                    Administrateur: [{appAdmin}]
                                </div>
                                <div class="items" style="grid-area: 2 / 4 / span 1 / span 3">
                                    Editeur: [{appEdit}]
                                </div>
                                <div class="items" style="grid-area: 3 / 1 / span 1 / span 3">
                                    Date d'ajout: [{appDate}]
                                </div>
                                <div class="items" style="grid-area: 3 / 4 / span 1 / span 3">
                                    Statut: [{appStat}]
                                </div>
                                <div class="items" style="grid-area: 4 / 1 / span 1 / span 2">
                                    <div>
                                        <div>Type de solution:</div>
                                        <div>[{appSol}]</div>
                                    </div>
                                </div>
                                <div class="items" style="grid-area: 4 / 3 / span 1 / span 2">
                                    <div>
                                        <div>Type d'application:</div>
                                        <div>[{appTApp}]</div>
                                    </div>
                                </div>
                                <div class="items" style="grid-area: 4 / 5 / span 1 / span 2">
                                    <div>
                                        <div>Type d'architecture:</div>
                                        <div>[{appArch}]</div>
                                    </div>
                                </div>
                                <div class="items" style="grid-area: 5 / 1 / span 1 / span 3">
                                    Langage: [{appLang}]
                                </div>
                                <div class="items" style="grid-area: 5 / 4 / span 1 / span 3">
                                    PlateForme: [{appPtf}]
                                </div>
                                <div class="items" style="grid-area: 6 / 1 / span 1 / span 3">
                                    Base de donnees: [{appDB}]
                                </div>
                                <div class="items" style="grid-area: 6 / 4 / span 1 / span 3">
                                    Middleware: [{appMW}]
                                </div>
                                <div class="items" style="grid-area: 7 / 1 / span 1 / span 6">
                                    <div class="subItems">
                                        <div>La version: </div>
                                        <select id="ver" ng-model="appIde" ng-change="selectVersion()">
                                            <option value="" selected disabled>-- elements --</option>
                                            <option ng-repeat="version in VersionS" value="[{version.appID}]">[{version.version}]</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- ces elements ne s'affichent que apres le choix d'une version --}}
                                <div ng-show="disableBtn" class="items" style="grid-area: 8 / 1 / span 1 / span 2">
                                    <div class="subItems">
                                        <div>Documentation:</div>
                                        <button><a href="/contollers/ExploreApp/Download[{Docpath}]">Telecharger</a></button>
                                    </div>
                                </div>
                                <div ng-show="disableBtn" class="items" style="grid-area: 8 / 3 / span 1 / span 2">
                                    <div class="subItems">
                                        <div>Code source:</div>
                                        <button><a href="/contollers/ExploreApp/Download[{SCpath}]">Telecharger</a></button>
                                    </div>
                                </div>
                                <div ng-show="disableBtn" class="items" style="grid-area: 8 / 5 / span 1 / span 2">
                                    <div class="subItems">
                                        <div>Application:</div>
                                        <button><a href="[{Exepath}]">Telecharger</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="descContainer">
                            <div>Description</div>
                            <p>[{appDesc}]</p>
                        </div>
                    </div>
                </div>
            </div>



        </main>
    </div>
    <script src="/js//angular/angular.min.js"></script>
    <script src="/js/ExploreItems.js"></script>
</body>

</html>