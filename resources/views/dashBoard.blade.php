<!DOCTYPE html>
<html lang="en" ng-app="dashBoardModule">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table De Bord</title>
    <link rel="shortcut icon" href="/icon/ONCForiginal.svg" />
    <link rel="stylesheet" href="/FAicons/css/all.css">
    <link rel="stylesheet" href="/css/DashBord_style.css">
    <link rel="stylesheet" href="/css/navHeader_style.css">
</head>

<body ng-controller="dashBoardCtrl">
    @include('navHeader')

    <main>
        <div id="mainGridContainer">
            {{-- table des Départements --}}
            <div id="Dept">
                <div class="mainItemHead">Département</div>
                <div class="mainItemBody">
                    <table class="tab3Col">
                        @foreach ($departments as $department)
                            <tr>
                                <td class="cel1">{{ $department->departmentID }}</td>
                                <td class="cel2">{{ $department->departmentName }}</td>
                                {{-- le clic sur ce button permet de supprimer l'element selectionné  --}}
                                <td class="cel3"><a class="fa-solid fa-square-minus" href="/contollers/Dashboard/delete/departments/departmentID/{{ $department->departmentID }}"></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <form class="mainItemFooter">
                    <div class="inputFld">
                        <input type="text" placeholder="Ajoutez une département" ng-model="rowContent1">
                    </div>
                    <div class="btnFld">
                        {{-- le clic sur ce button permet d'ajouter l'element selectionné  --}}
                        <button ng-click="addRow(rowContent1, 'departments', 'departmentName')" class="fa-solid fa-square-plus"></button>
                        <button type="reset" class="fa-solid fa-square-xmark"></button>
                    </div>
                </form>
            </div>
            {{-- table des Services --}}
            <div id="Serv">
                <div class="mainItemHead">Service</div>
                <div class="mainItemBody">
                    <table class="tab3Col">
                        @foreach ($services as $service)
                            <tr>
                                <td class="cel1">{{ $service->serviceID }}</td>
                                <td class="cel2">{{ $service->serviceName }}</td>
                                <td class="cel3"><a class="fa-solid fa-square-minus" href="/contollers/Dashboard/delete/services/serviceID/{{ $service->serviceID }}"></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <form class="mainItemFooter">
                    <div class="inputFld">
                        <input type="text" placeholder="Ajoutez une département" ng-model="rowContent2">
                    </div>
                    <div class="btnFld">
                        <button ng-click="addRow(rowContent2, 'services', 'serviceName')" class="fa-solid fa-square-plus"></button>
                        <button type="reset" class="fa-solid fa-square-xmark"></button>
                    </div>
                </form>
            </div>
            {{-- table des Administrateurs --}}
            <div id="Admin">
                <div class="mainItemHead">Administarteur</div>
                <div class="mainItemBody">
                    <table class="tab3Col">
                        @foreach ($admins as $admin)
                            <tr>
                                <td class="cel1">{{ $admin->login }}</td>
                                <td class="cel2">{{ $admin->employeeName }}</td>
                                <td class="cel3"><a class="fa-solid fa-square-minus" href="/contollers/Dashboard/delAdmin/{{ $admin->employeeID }}"></a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="mainItemFooter">
                    <button class="fa-solid fa-square-plus" ng-click="openModal1()"></button>
                </div>
            </div>
            {{-- table des Editeurs --}}
            <div id="Edit">
                <div class="mainItemHead">Editeur</div>
                <div class="mainItemBody">
                    <table class="tab3Col">
                        @foreach ($editors as $editor)
                            <tr>
                                <td class="cel1">{{ $editor->editorID }}</td>
                                <td class="cel2">{{ $editor->editorName }}</td>
                                <td class="cel3"><a class="fa-solid fa-square-minus" href="/contollers/Dashboard/delete/editors/editorID/{{ $editor->editorID }}"></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <form class="mainItemFooter">
                    <div class="inputFld">
                        <input type="text" placeholder="Ajoutez une département" ng-model="rowContent3">
                    </div>
                    <div class="btnFld">
                        <button ng-click="addRow(rowContent3, 'editors', 'editorName')" class="fa-solid fa-square-plus"></button>
                        <button type="reset" class="fa-solid fa-square-xmark"></button>
                    </div>
                </form>
            </div>
            {{-- table de type des solutions --}}
            <div id="TS">
                <div class="mainItemHead">Type de solution</div>
                <div class="mainItemBody">
                    <table class="tab2Col">
                        @foreach ($solutiontypes as $solutiontype)
                            <tr>
                                <td class="cel1">{{ $solutiontype->solutiontypeName }}</td>
                                <td class="cel2"><a class="fa-solid fa-square-minus" href="/contollers/Dashboard/delete/solutiontypes/solutiontypeID/{{ $solutiontype->solutiontypeID }}"></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <form class="mainItemFooter">
                    <div class="inputFld">
                        <input type="text" placeholder="Ajoutez une département" ng-model="rowContent4">
                    </div>
                    <div class="btnFld">
                        <button ng-click="addRow(rowContent4, 'solutiontypes', 'solutiontypeName')" class="fa-solid fa-square-plus"></button>
                        <button type="reset" class="fa-solid fa-square-xmark"></button>
                    </div>
                </form>
            </div>
            {{-- table de type des applications --}}
            <div id="TAp">
                <div class="mainItemHead">Type d'application</div>
                <div class="mainItemBody">
                    <table class="tab2Col">
                        @foreach ($applicationtypes as $applicationtype)
                            <tr>
                                <td class="cel1">{{ $applicationtype->applicationtypeName }}</td>
                                <td class="cel2"><a class="fa-solid fa-square-minus" href="/contollers/Dashboard/delete/applicationtypes/applicationtypeID/{{ $applicationtype->applicationtypeID }}"></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <form class="mainItemFooter">
                    <div class="inputFld">
                        <input type="text" placeholder="Ajoutez une département" ng-model="rowContent5">
                    </div>
                    <div class="btnFld">
                        <button ng-click="addRow(rowContent5, 'applicationtypes', 'applicationtypeName')"
                            class="fa-solid fa-square-plus"></button>
                        <button type="reset" class="fa-solid fa-square-xmark"></button>
                    </div>
                </form>
            </div>
            {{-- table de type des architectures --}}
            <div id="TAr">
                <div class="mainItemHead">Type d'architecture</div>
                <div class="mainItemBody">
                    <table class="tab2Col">
                        @foreach ($architecturetypes as $architecturetype)
                            <tr>
                                <td class="cel1">{{ $architecturetype->architecturetypeName }}</td>
                                <td class="cel2"><a class="fa-solid fa-square-minus" href="/contollers/Dashboard/delete/architecturetypes/architecturetypeID/{{ $architecturetype->architecturetypeID }}"></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <form class="mainItemFooter">
                    <div class="inputFld">
                        <input type="text" placeholder="Ajoutez une département" ng-model="rowContent6">
                    </div>
                    <div class="btnFld">
                        <button ng-click="addRow(rowContent6, 'architecturetypes', 'architecturetypeName')" class="fa-solid fa-square-plus"></button>
                        <button type="reset" class="fa-solid fa-square-xmark"></button>
                    </div>
                </form>
            </div>
            {{-- table de type des APIs --}}
            <div id="TApi">
                <div class="mainItemHead">Type API</div>
                <div class="mainItemBody">
                    <table class="tab2Col">
                        @foreach ($apitypes as $apitype)
                            <tr>
                                <td class="cel1">{{ $apitype->apitypeName }}</td>
                                <td class="cel2"><a class="fa-solid fa-square-minus" href="/contollers/Dashboard/delete/apitypes/apitypeID/{{ $apitype->apitypeID }}"></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <form class="mainItemFooter">
                    <div class="inputFld">
                        <input type="text" placeholder="Ajoutez une département" ng-model="rowContent7">
                    </div>
                    <div class="btnFld">
                        <button ng-click="addRow(rowContent7, 'apitypes', 'apitypeName')" class="fa-solid fa-square-plus"></button>
                        <button type="reset" class="fa-solid fa-square-xmark"></button>
                    </div>
                </form>
            </div>
            {{-- table de type des reponse APIs --}}
            <div id="Res">
                <div class="mainItemHead">Reponse</div>
                <div class="mainItemBody">
                    <table class="tab2Col">
                        @foreach ($apiresponses as $apiresponse)
                            <tr>
                                <td class="cel1">{{ $apiresponse->apiresponseName }}</td>
                                <td class="cel2"><a class="fa-solid fa-square-minus" href="/contollers/Dashboard/delete/apiresponses/apiresponseID/{{ $apiresponse->apiresponseID }}"></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <form class="mainItemFooter">
                    <div class="inputFld">
                        <input type="text" placeholder="Ajoutez une département" ng-model="rowContent8">
                    </div>
                    <div class="btnFld">
                        <button ng-click="addRow(rowContent8, 'apiresponses', 'apiresponseName')" class="fa-solid fa-square-plus"></button>
                        <button type="reset" class="fa-solid fa-square-xmark"></button>
                    </div>
                </form>
            </div>
            {{-- table des plateformes --}}
            <div id="PF">
                <div class="mainItemHead">PlateForme</div>
                <div class="mainItemBody">
                    <table class="tab2Col">
                        @foreach ($platforms as $platform)
                            <tr>
                                <td class="cel1">{{ $platform->platformName }}</td>
                                <td class="cel2"><a class="fa-solid fa-square-minus" href="/contollers/Dashboard/delete/platforms/platformID/{{ $platform->platformID }}"></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <form class="mainItemFooter">
                    <div class="inputFld">
                        <input type="text" placeholder="Ajoutez une département" ng-model="rowContent9">
                    </div>
                    <div class="btnFld">
                        <button ng-click="addRow(rowContent9, 'platforms', 'platformName')" class="fa-solid fa-square-plus"></button>
                        <button type="reset" class="fa-solid fa-square-xmark"></button>
                    </div>
                </form>
            </div>
            {{-- table des bases de données --}}
            <div id="DB">
                <div class="mainItemHead">Base de données</div>
                <div class="mainItemBody">
                    <table class="tab2Col">
                        @foreach ($databases as $database)
                            <tr>
                                <td class="cel1">{{ $database->databaseName }}</td>
                                <td class="cel2"><a class="fa-solid fa-square-minus" href="/contollers/Dashboard/delete/databases/databaseID/{{ $database->databaseID }}"></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <form class="mainItemFooter">
                    <div class="inputFld">
                        <input type="text" placeholder="Ajoutez une département" ng-model="rowContent10">
                    </div>
                    <div class="btnFld">
                        <button ng-click="addRow(rowContent10, 'databases', 'databaseName')" class="fa-solid fa-square-plus"></button>
                        <button type="reset" class="fa-solid fa-square-xmark"></button>
                    </div>
                </form>
            </div>
            {{-- table des langages --}}
            <div id="Lang">
                <div class="mainItemHead">Languages</div>
                <div class="mainItemBody">
                    <table class="tab2Col">
                        @foreach ($languages as $language)
                            <tr>
                                <td class="cel1">{{ $language->languageName }}</td>
                                <td class="cel2"><a class="fa-solid fa-square-minus" href="/contollers/Dashboard/delete/languages/languageID/{{ $language->languageID }}"></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <form class="mainItemFooter">
                    <div class="inputFld">
                        <input type="text" placeholder="Ajoutez une département" ng-model="rowContent11">
                    </div>
                    <div class="btnFld">
                        <button ng-click="addRow(rowContent11, 'languages', 'languageName')" class="fa-solid fa-square-plus"></button>
                        <button type="reset" class="fa-solid fa-square-xmark"></button>
                    </div>
                </form>
            </div>
            {{-- table des serveurs (middleware) --}}
            <div id="MW">
                <div class="mainItemHead">Middleware</div>
                <div class="mainItemBody">
                    <table class="tab2Col">
                        @foreach ($middleware as $mw)
                            <tr>
                                <td class="cel1">{{ $mw->middlewareName }}</td>
                                <td class="cel2"><a class="fa-solid fa-square-minus" href="/contollers/Dashboard/delete/middleware/middlewareID/{{ $mw->middlewareID }}"></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <form class="mainItemFooter">
                    <div class="inputFld">
                        <input type="text" placeholder="Ajoutez une département" ng-model="rowContent12">
                    </div>
                    <div class="btnFld">
                        <button ng-click="addRow(rowContent12, 'middleware', 'middlewareName')" class="fa-solid fa-square-plus"></button>
                        <button type="reset" class="fa-solid fa-square-xmark"></button>
                    </div>
                </form>
            </div>
            {{-- table des applications --}}
            <div id="App">
                <div class="mainItemHead">Les applications</div>
                <div class="mainItemBody" style="border-bottom: #251D3A 5px solid;">
                    <table class="tab4Col">
                        @foreach ($apps as $app)
                        <tr>
                            <td class="cel1">{{ $app->appCode }}</td>
                            <td class="cel2">{{ $app->version }}</td>
                            <td class="cel3">{{ $app->appName }}</td>
                            <td class="cel4"><i id="{{ $app->appID }}" data-ng-click="openModal2($event)" class="fa-solid fa-square-pen"></i></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            {{-- table des APIs --}}
            <div id="Api">
                <div class="mainItemHead">Les APIs</div>
                <div class="mainItemBody" style="border-bottom: #251D3A 5px solid;">
                    <table class="tab4Col">
                        @foreach ($apis as $api)
                        <tr>
                            <td class="cel1">{{ $api->apiCode }}</td>
                            <td class="cel2">{{ $api->version }}</td>
                            <td class="cel3">{{ $api->apiName }}</td>
                            <td class="cel4"><i id="{{ $api->apiID }}" data-ng-click="openModal3($event)" class="fa-solid fa-square-pen"></i></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </main>

    {{-- la section pour ajouter des nouveaux administrateurs --}}
    <div class="openMmodal" ng-show="modal1Visibility">
        <div class="modalContainer">
            <div class="fa-solid fa-arrow-left-long backIcon" ng-click="closeModal1()"></div>
            <div id="searchContainer">
                <input type="text" placeholder="cherchez un employé" ng-model="empSearch.employeeName">
            </div>
            <form action="/contollers/Dashboard/addAdmins" method="post">
                @csrf
                <div id="employeesContainer">
                    <table>
                        <thead>
                            <tr>
                                <td class="id">ID</td>
                                <td class="nom">Nom complet</td>
                                <td class="check">f</td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr ng-repeat="employee in employees | filter: empSearch">
                                <td class="id">[{employee.login}]</td>
                                <td class="nom">[{employee.employeeName}]</td>
                                <td class="check">
                                    <input type="checkbox" name="employees[]" value="[{employee.employeeID}]" id="emp[{employee.employeeID}]">
                                    <label for="emp[{employee.employeeID}]" class="empOpt">
                                        <i class="fa-regular fa-square"></i>
                                        <i class="fa-regular fa-square-check"></i>
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="submitButton">
                    <button type="submit">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
    {{-- la section pour modifier l'application selectionnée --}}
    <div class="openMmodal" ng-show="modal2Visibility">
        <div class="modalContainer">
            <div class="fa-solid fa-arrow-left-long backIcon" ng-click="closeModal2()"></div>
            <div class="subEditModalContainer">
                <form action="/contollers/Dashboard/editApp" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="gridContainer">
                        <div class="items" style="grid-area: 1 / 1 / span 1 / span 3">
                            <label>Code d'APP</label>
                            <input type="text" name="AppCode" ng-model="appCode" disabled>
                        </div>
                        <div class="items" style="grid-area: 1 / 4 / span 1 / span 3">
                            <label>Nom d'APP</label>
                            <input type="text" name="AppName" ng-model="appName">
                        </div>
            
                        <div class="items" style="grid-area: 2 / 1 / span 1 / span 3">
                            <label>Statut</label>
                            <select name="AppStatus" id="AppStatus" >
                            @foreach ($statuses as $status)
                            <option value="{{ $status->statusName }}">{{ $status->statusName }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="items" style="grid-area: 2 / 4 / span 1 / span 3">
                            <label>Version</label>
                            <input type="text" name="AppVersion" ng-model="appVersion" ng-blur="checkversion()">
                        </div>
            
                        <div class="items" style="grid-area: 3 / 1 / span 1 / span 3">
                            <label>Departement</label>
                            <select name="AppDept" id="AppDept">
                            @foreach ($departments as $department)
                            <option value="{{ $department->departmentName }}">{{ $department->departmentName }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="items" style="grid-area: 3 / 4 / span 1 / span 3">
                            <label>Service</label>
                            <select name="AppServ" id="AppServ">
                            @foreach ($services as $service)
                            <option value="{{ $service->serviceName }}">{{ $service->serviceName }}</option>
                            @endforeach
                            </select>
                        </div>
            
                        <div class="items" style="grid-area: 4 / 1 / span 1 / span 3">
                            <label>Admin fonctionnel</label>
                            <input type="text" name="AppAdmin" ng-model="appAdmin" disabled>
                        </div>
                        <div class="items" style="grid-area: 4 / 4 / span 1 / span 3">
                            <label>Editeur</label>
                            <select name="AppEditor" id="AppEditor">
                            @foreach ($editors as $editor)
                            <option value="{{ $editor->editorName }}">{{ $editor->editorName }}</option>
                            @endforeach
                            </select>
                        </div>
            
                        <div class="items" style="grid-area: 5 / 1 / span 1 / span 2">
                            <label>Type de solution</label>
                            <select name="AppTSlt" id="AppTSlt">
                            @foreach ($solutiontypes as $solutiontype)
                            <option value="{{ $solutiontype->solutiontypeName }}">{{ $solutiontype->solutiontypeName }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="items" style="grid-area: 5 / 3 / span 1 / span 2">
                            <label>Type d'application</label>
                            <select name="AppTApp" id="AppTApp">
                            @foreach ($applicationtypes as $applicationtype)
                            <option value="{{ $applicationtype->applicationtypeName }}">{{ $applicationtype->applicationtypeName }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="items" style="grid-area: 5 / 5 / span 1 / span 2">
                            <label>Type d'architecture</label>
                            <select name="AppTArcht" id="AppTArcht">
                            @foreach ($architecturetypes as $architecturetype)
                            <option value="{{ $architecturetype->architecturetypeName }}">{{ $architecturetype->architecturetypeName }}</option>
                            @endforeach
                            </select>
                        </div>
            
                        <div class="items" style="grid-area: 6 / 1 / span 1 / span 3">
                            <label>Langage</label>
                            <div class="langContainer">
                            <div class="langCheckBox">
                                @foreach ($languages as $language)
                                <input type="checkbox" name="AppLang[]" value="{{$language->languageID}}" id="appLang{{$language->languageID}}" class="langOpt appLangCheck">
                                <label for="appLang{{$language->languageID}}">{{$language->languageName}}</label>
                                @endforeach
                            </div>
                            </div>
                        </div>
                        <div class="items" style="grid-area: 6 / 4 / span 1 / span 3">
                            <label>PlateForme</label>
                            <select name="AppPtf" id="AppPtf">
                            @foreach ($platforms as $platform)
                            <option value="{{ $platform->platformName }}">{{ $platform->platformName }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="items" style="grid-area: 7 / 1 / span 1 / span 3">
                            <label>Base de données</label>
                            <select name="AppDB" id="AppDB">
                            @foreach ($databases as $database)
                            <option value="{{ $database->databaseName }}">{{ $database->databaseName }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="items" style="grid-area: 7 / 4 / span 1 / span 3">
                            <label>Middleware</label>
                            <select name="AppMW" id="AppMW">
                            @foreach ($middleware as $mw)
                            <option value="{{ $mw->middlewareName }}">{{ $mw->middlewareName }}</option>
                            @endforeach
                            </select>
                        </div>
            
                        <div class="items" style="grid-area: 8 / 1 / span 1 / span 6">
                            <label>Documentation</label>
                            <label for="appDocumentation" class="fa-solid fa-file-arrow-up inputFileIcon"></label>
                            <input type="file" name="AppDoc" id="appDocumentation" accept=".pdf">
                            <input type="hidden" id="OldAppDocument" name="OldAppDoc">
                        </div>
            
                        <div class="items" style="grid-area: 9 / 1 / span 1 / span 6">
                            <label>Description</label>
                            <textarea name="AppDesc" ng-model="appDescription"></textarea>
                        </div>
            
                        <div class="items" style="grid-area: 10 / 1 / span 1 / span 6">
                            <label>logo de l'application</label>
                            <input type="file" name="AppImg" onchange="angular.element(this).scope().SelectImg(event)" id="appUploadImg" accept=".jpg, .jpeg, .png">
                            <input type="hidden" id="OldAppImage" name="OldAppImg">
                            <div>
                                <label for="appUploadImg" class="fa-solid fa-square-plus imgIcon"></label>
                                <i ng-click="delImg('app')" class="fa-solid fa-square-minus imgIcon"></i>
                            </div>
                            <img src="[{appIcon}]" class="PreviewImage" ng-show="appIconDiplay" >
                        </div>
                        {{-- AppID input --}}
                        <input type="hidden" name="AppID" id="appID">
                    </div>
                    <button type="submit">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
    {{-- la section pour modifier l'API selectionnée --}}
    <div class="openMmodal" ng-show="modal3Visibility">
        <div class="modalContainer">
            <div class="fa-solid fa-arrow-left-long backIcon" ng-click="closeModal3()"></div>
            <div class="subEditModalContainer">
                <form action="/contollers/Dashboard/editApi" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="gridContainer">
                        <div class="items" style="grid-area: 1 / 1 / span 1 / span 2">
                            <label>Code d'API</label>
                            <input type="text" name="ApiCode" ng-model="apiCode" readonly>
                        </div>
                        <div class="items" style="grid-area: 1 / 3 / span 1 / span 2">
                            <label>Nom d'API</label>
                            <input type="text" name="ApiName" ng-model="apiName">
                        </div>
                        <div class="items" style="grid-area: 1 / 5 / span 1 / span 2">
                            <label>Version</label>
                            <input type="text" name="ApiVersion" ng-model="apiVersion">
                        </div>
    
                        <div class="items" style="grid-area: 2 / 1 / span 1 / span 3">
                            <label>Departement</label>
                            <select name="ApiDept" id="ApiDept">
                            @foreach ($departments as $department)
                                <option value="{{ $department->departmentName }}">{{ $department->departmentName }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="items" style="grid-area: 2 / 4 / span 1 / span 3">
                            <label>Service</label>
                            <select name="ApiServ" id="ApiServ">
                            @foreach ($services as $service)
                                <option value="{{ $service->serviceName }}">{{ $service->serviceName }}</option>
                            @endforeach
                            </select>
                        </div>
    
                        <div class="items" style="grid-area: 3 / 1 / span 1 / span 3">
                            <label>Admin fonctionnel</label>
                            <input type="text" name="ApiAdmin" ng-model="apiAdmin" disabled>
                        </div>
                        <div class="items" style="grid-area: 3 / 4 / span 1 / span 3">
                            <label>Editeur</label>
                            <select name="ApiEditor" id="ApiEditor">
                            @foreach ($editors as $editor)
                                <option value="{{ $editor->editorName }}">{{ $editor->editorName }}</option>
                            @endforeach
                            </select>
                        </div>
    
                        <div class="items" style="grid-area: 4 / 1 / span 1 / span 3">
                            <label>Statut</label>
                            <select name="ApiStatus" id="ApiStatus">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->statusName }}">{{ $status->statusName }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="items" style="grid-area: 4 / 4 / span 1 / span 3">
                            <label>Securisé</label>
                            <div id="security">
                                <input type="radio" name="ApiSecurity" value="OUI" id="secYes" class="opt" checked>
                                <label for="secYes">Oui</label>
                                <input type="radio" name="ApiSecurity" value="NON" id="secNo" class="opt">
                                <label for="secNo">No</label>
                            </div>
                        </div>
    
                        <div class="items" style="grid-area: 5 / 1 / span 1 / span 3">
                            <label>Type</label>
                            <select name="ApiType" id="ApiType">
                            @foreach ($apitypes as $apitype)
                                <option value="{{ $apitype->apitypeName }}">{{ $apitype->apitypeName }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="items" style="grid-area: 5 / 4 / span 1 / span 3">
                            <label>Format</label>
                            <select name="ApiResponse" id="ApiResponse">
                            @foreach ($apiresponses as $apiresponse)
                                <option value="{{ $apiresponse->apiresponseName }}">{{ $apiresponse->apiresponseName }}</option>
                            @endforeach
                            </select>
                        </div>
    
                        <div class="items" style="grid-area: 6 / 1 / span 1 / span 2">
                            <label>Langage</label>
                            <div class="langContainer">
                                <div class="langCheckBox">
                                    @foreach ($languages as $language)
                                    <input type="checkbox" name="ApiLang[]" value="{{$language->languageID}}" id="apiLang{{$language->languageID}}" class="langOpt apiLangCheck">
                                    <label for="apiLang{{$language->languageID}}">{{$language->languageName}}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="items" style="grid-area: 6 / 3 / span 1 / span 2">
                            <label>Base de données</label>
                            <select name="ApiDB" id="ApiDB">
                            @foreach ($databases as $database)
                                <option value="{{ $database->databaseName }}">{{ $database->databaseName }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="items" style="grid-area: 6 / 5 / span 1 / span 2">
                            <label>Middleware</label>
                            <select name="ApiMW" id="ApiMW">
                            @foreach ($middleware as $mw)
                                <option value="{{ $mw->middlewareName }}">{{ $mw->middlewareName }}</option>
                            @endforeach
                            </select>
                        </div>
    
                        <div class="items" style="grid-area: 7 / 1 / span 1 / span 6">
                            <label >Documentation</label>
                            <label for="apiDocumentation" class="fa-solid fa-file-arrow-up inputFileIcon"></label>
                            <input type="file" name="ApiDoc" id="apiDocumentation" accept=".pdf">
                            <input type="hidden" id="OldApiDocument" name="OldApiDoc">
                        </div>
    
                        <div class="items" style="grid-area: 8 / 1 / span 1 / span 6">
                            <label>Description</label>
                            <textarea name="ApiDesc" ng-model="apiDescription"></textarea>
                        </div>
    
                        <div class="items" style="grid-area: 9 / 1 / span 1 / span 6">
                            <label>logo de l'API</label>
                            <input type="file" name="ApiImg" onchange="angular.element(this).scope().SelectImg(event)" id="apiUploadImg" accept=".jpg, .jpeg, .png">
                            <input type="hidden" id="OldApiImage" name="OldApiImg">
                            <div>
                                <label for="apiUploadImg" class="fa-solid fa-square-plus imgIcon"></label>
                                <i ng-click="delImg('api')" class="fa-solid fa-square-minus imgIcon"></i>
                            </div>
                            <img src="[{apiIcon}]" class="PreviewImage" ng-show="apiIconDiplay" >
                        </div>
                        {{-- AppID input --}}
                        <input type="hidden" name="ApiID" id="apiID">
                    </div>
                    <button type="submit">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</body>

<script src="/js//angular/angular.min.js"></script>
<script src="/js/dashBoard.js"></script>

</html>
