<!DOCTYPE html>
<html lang="en" ng-app="exploreItems">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore APIs</title>
    <link rel="shortcut icon" href="/icon/ONCForiginal.svg" />
    <link rel="stylesheet" href="/FAicons/css/all.css">
    <link rel="stylesheet" href="/css/ExploreApi_style.css">
    <link rel="stylesheet" href="/css/navHeader_style.css">
</head>

<body ng-controller="exploreApi">
    @include('navHeader')
    <div id="rightSide">
        <main>
            {{-- la section pour chercher une API par le nom --}}
            <form method="get" action="/contollers/ExploreApi/SearchApi" id="haidContainer">
                <input type="text" name="apiName" placeholder="Chercher içi...">
                <button type="submit" class="fa-solid fa-magnifying-glass fa-2xl"></button>
            </form>
            @foreach ($apis as $api)
            <article id="{{ $api->apiCode }}" data-ng-click="preparemodal($event)">
                <div class="imgContainer">
                    <img src="{{$api->apiIcon}}" alt="Logo Img">
                </div>
                <div class="infoContainer">
                    <h1>{{$api->apiCode . " - " . $api->apiName}}</h1>
                    <table>
                        <tr>
                            <td>Departement: {{$api->department}}</td>
                            <td>Service: {{$api->service}}</td>
                        </tr>
                        <tr>
                            <td>Admin: {{$api->employeeName}}</td>
                            <td>Editeur: {{$api->editor}}</td>
                        </tr>
                        <tr>
                            <td>Type de l'API: {{$api->apiType}}</td>
                            <td>Type de reponse: {{$api->apiResponse}}</td>
                        </tr>
                    </table>
                    <div>Description</div>
                    <p>{{$api->description}}</p>
                </div>
            </article>
            @endforeach

            {{-- la section pour afficher les informations detaillées de l'API selectionnée --}}
            <div id="detailsApiMmodal" ng-show="modalVisibility">
                <div id="modelContainer">
                    <div id="backIcon" class="fa-solid fa-arrow-left-long" ng-click="closeModal()"></div>
                    <div id="contentContainer">
                        <div id="imgContainer">
                            <img src="[{apiImgSrc}]" alt="Logo Img">
                        </div>
                        <div id="infoContainer">
                            <h1>[{apiCode}] - [{apiName}]</h1>
                
                            <div id="gridContainer">
                                <div class="items" style="grid-area: 1 / 1 / span 1 / span 3">
                                    Departement: [{apiDept}]
                                </div>
                                <div class="items" style="grid-area: 1 / 4 / span 1 / span 3">
                                    Service: [{apiServ}]
                                </div>
                                <div class="items" style="grid-area: 2 / 1 / span 1 / span 3">
                                    Administrateur: [{apiAdmin}]
                                </div>
                                <div class="items" style="grid-area: 2 / 4 / span 1 / span 3">
                                    Editeur: [{apiEdit}]
                                </div>
                                <div class="items centeredItems" style="grid-area: 3 / 1 / span 1 / span 2">
                                    <div>
                                        <div>Date d'ajout:</div>
                                        <div>[{apiDate}]</div>
                                    </div>
                                </div>
                                <div class="items centeredItems" style="grid-area: 3 / 3 / span 1 / span 2">
                                    <div>
                                        <div>Statut:</div>
                                        <div>[{apiStat}]</div>
                                    </div>
                                </div>
                                <div class="items centeredItems" style="grid-area: 3 / 5 / span 1 / span 2">
                                    <div>
                                        <div>Securisé:</div>
                                        <div>[{apiSec}]</div>
                                    </div>
                                </div>
                                <div class="items" style="grid-area: 4 / 1 / span 1 / span 3">
                                    Type: [{apiType}]
                                </div>
                                <div class="items" style="grid-area: 4 / 4 / span 1 / span 3">
                                    Format: [{apiResponse}]
                                </div>
                                <div class="items" style="grid-area: 5 / 1 / span 1 / span 2">
                                    <div>
                                        <div>Langage:</div>
                                        <div>[{apiLang}]</div>
                                    </div>
                                </div>
                                <div class="items" style="grid-area: 5 / 3 / span 1 / span 2">
                                    <div>
                                        <div>Base de donnees:</div>
                                        <div>[{apiDB}]</div>
                                    </div>
                                </div>
                                <div class="items" style="grid-area: 5 / 5 / span 1 / span 2">
                                    <div>
                                        <div>Middleware:</div>
                                        <div>[{apiMW}]</div>
                                    </div>
                                </div>
                                <div class="items centeredItems" style="grid-area: 6 / 1 / span 1 / span 6">
                                    <div class="subItems">
                                        <div>La version:</div>
                                        <select id="ver" ng-model="apiIde" ng-change="selectVersion()">
                                            <option value="" selected disabled>-- elements --</option>
                                            <option ng-repeat="version in VersionS" value="[{version.apiID}]">[{version.version}]</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- ces elements ne s'affichent que apres le choix d'une version --}}
                                <div ng-show="disableBtn" class="items centeredItems" style="grid-area: 7 / 1 / span 1 / span 3">
                                    <div class="subItems">
                                        <div>Documentation: </div>
                                        <button><a href="/contollers/ExploreApi/Download[{Docpath}]">Telecharger</a></button>
                                    </div>
                                </div>
                
                                <div ng-show="disableBtn" class="items centeredItems" style="grid-area: 7 / 4 / span 1 / span 3">
                                    <div class="subItems">
                                        <div>Code source: </div>
                                        <button><a href="/contollers/ExploreApi/Download[{SCpath}]">Telecharger</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="descContainer">
                            <div>Description</div>
                            <p>[{apiDesc}]</p>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
    <script src="/js/angular/angular.min.js"></script>
    <script src="/js/ExploreItems.js"></script>
</body>

</html>