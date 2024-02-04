<!DOCTYPE html>
<html lang="en" ng-app="addAApi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AddApi</title>
    <link rel="shortcut icon" href="/icon/ONCForiginal.svg" />
    <link rel="stylesheet" href="/FAicons/css/all.css">
    <link rel="stylesheet" href="/css/AddApi_style.css">
    <link rel="stylesheet" href="/css/navHeader_style.css">
	{{-- le "_token" pour l'uitiliser avec la bibliothé que ResumableJS --}}
    <meta name="_token" content="{{ csrf_token() }}">
</head>

<body ng-controller="addApiCtrl">
    @include('navHeader')

    <main>
		<div id="head">
			{{-- la section où l'administrateur peut choisir entre le type d'API à ajouter (nouvelle API ou nouvelle version d'une API) --}}
            <span>
                <div>Ajouter une nouvelle API</div>
                <button ng-click="newApi()">Nouvelle API</button>
            </span>
            <span>
                <div>Ajouter une nouvelle version d'une API</div>
                <select id=ApiSelector ng-model="LastApiCode" ng-change="selectApi()">
                    <option value="" selected disabled>-- element --</option>
                    <option ng-repeat="apiCodeScope in apiCodesScope" value="[{apiCodeScope.apiCode}]">
                        [{apiCodeScope.apiCode}]</option>
                </select>
            </span>
        </div>
        <form action="/contollers/AddApi" method="POST" enctype="multipart/form-data">
            @csrf
			{{-- la section où l'administrateur peut inserer les informations de l'API a ajouter --}}
            <div id="gridContainer">
                <div class="items" style="grid-area: 1 / 1 / span 1 / span 2">
                    <label>Code d'API</label>
                    <input type="text" name="ApiCode" ng-model="codeInput" required>
                </div>
                <div class="items" style="grid-area: 1 / 3 / span 1 / span 2">
                    <label>Nom d'API</label>
                    <input type="text" name="ApiName" ng-model="nomInput" required>
                </div>
                <div class="items" style="grid-area: 1 / 5 / span 1 / span 2">
                    <label>Version</label>
                    <input type="text" name="ApiVersion" ng-model="versionInput" required>
                </div>

                <div class="items" style="grid-area: 2 / 1 / span 1 / span 3">
                    <label>Departement</label>
                    <select name="ApiDept" id="ApiDept">
                        @foreach ($departments as $department)
                            <option value="{{ $department->departmentName }}">{{ $department->departmentName }}
                            </option>
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
                    <input type="text" name="ApiAdmin" value="{{ Session::get('employeeName') }}" disabled>
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
                            <option value="{{ $apiresponse->apiresponseName }}">
                                {{ $apiresponse->apiresponseName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="items" style="grid-area: 6 / 1 / span 1 / span 2">
                    <label>Langage</label>
                    <div id="langContainer">
                        <div id="langCheckBox">
                            @foreach ($languages as $language)
                                <input type="checkbox" name="ApiLang[]" value="{{ $language->languageID }}"
                                    name="language" id="lang{{ $language->languageID }}" class="langOpt"
                                    ng-checked="checkLang">
                                <label for="lang{{ $language->languageID }}">{{ $language->languageName }}</label>
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
                        @foreach ($middleware as $middleware)
                            <option value="{{ $middleware->middlewareName }}">{{ $middleware->middlewareName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="items" style="grid-area: 7 / 1 / span 1 / span 3">
                    <label>Documentation</label>
                    <i id="Documentation" class="fa-solid fa-file-arrow-up inputFileIcon"></i>
                    <input type="hidden" name="docPath" required id="docPath">
                </div>
                <div class="items" style="grid-area: 7 / 4 / span 1 / span 3">
                    <label>Code source</label>
                    <i id="SourceCode" class="fa-solid fa-file-arrow-up inputFileIcon"></i>
                    <input type="hidden" name="scPath" required id="scPath">
                </div>

                <div class="items" style="grid-area: 8 / 1 / span 1 / span 6">
                    <label>Description</label>
                    <textarea name="ApiDesc" ng-model="descirptionInput"></textarea>
                </div>

                <div class="items" style="grid-area: 9 / 1 / span 1 / span 6">
                    <label>logo de l'API</label>
                    <input type="file" name="ApiImg" onchange="angular.element(this).scope().SelectImg(event)"
                        id="uploadImg" accept=".jpg, .jpeg, .png, .svg">
                    <div>
                        <label for="uploadImg" class="fa-solid fa-square-plus imgIcon"></label>
                        <i ng-click="delImg()" class="fa-solid fa-square-minus imgIcon"></i>
                    </div>
                    <img ng-src="[{PreviewImage}]" id="PreviewImage" ng-show="imgDiplay">
                </div>
            </div>
            <button type="submit">Ajouter</button>
        </form>
    </main>

	{{-- cette section concerne l'affchage du porcentage du telechargement des fichiers (documentation et code source) --}}
    <div id="uploadBarMmodal" style="display: none">
        <div id="modelContainer">
            <div id="Progress_Status">
                <progress id="progressBar" max="100" value="90"></progress>
                <div id="progressValue"></div>
            </div>
        </div>
    </div>

    <script src="/js/angular/angular.min.js"></script>
    <script src="/js/resumable/resumable.min.js"></script>
    <script src="/js/addApi.js"></script>
</body>

</html>
