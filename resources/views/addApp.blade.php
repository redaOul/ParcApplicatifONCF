<!DOCTYPE html>
<html lang="en" ng-app="addApp">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AddApp</title>
    <link rel="shortcut icon" href="/icon/ONCForiginal.svg" />
    <link rel="stylesheet" href="/FAicons/css/all.css">
    <link rel="stylesheet" href="/css/AddApp_style.css">
    <link rel="stylesheet" href="/css/navHeader_style.css">
    {{-- le "_token" pour l'uitiliser avec la bibliothé que ResumableJS --}}
		<meta name="_token" content="{{ csrf_token() }}">
  </head>

  <body ng-controller="addAppCtrl">
    @include('navHeader')

    <main>
      <div id="head">
        {{-- la section où l'administrateur peut choisir entre le type d'application à ajouter (nouvelle application ou nouvelle version d'une application) --}}
        <span>
          <div>Ajouter une nouvelle application</div>
          <button ng-click="newApp()">Nouvelle application</button>
        </span>
        <span>
          <div>Ajouter une nouvelle version d'une application</div>
          <select id=AppSelector ng-model="LastAppCode" ng-change="selectApp()">
						<option value="" selected disabled>-- element --</option>
						<option ng-repeat="appCodeScope in appCodesScope" value="[{appCodeScope.appCode}]">[{appCodeScope.appCode}]</option>
					</select>
        </span>
      </div>
      <form action="/contollers/AddApp" method="POST" enctype="multipart/form-data">
			@csrf
			{{-- la section où l'administrateur peut inserer les informations de l'application a ajouter --}}
        <div id="gridContainer">
          <div class="items" style="grid-area: 1 / 1 / span 1 / span 3">
            <label>Code d'APP</label>
            <input type="text" name="AppCode" ng-model="codeInput" required>
          </div>
          <div class="items" style="grid-area: 1 / 4 / span 1 / span 3">
            <label>Nom d'APP</label>
            <input type="text" name="AppName" ng-model="nomInput" required>
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
            <input type="text" name="AppVersion" ng-model="versionInput" ng-blur="checkversion()" required>
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
            <input type="text" name="AppAdmin" value="{{ Session::get('employeeName') }}" disabled>
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
            <div id="langContainer">
              <div id="langCheckBox">
                @foreach ($languages as $language)
                <input type="checkbox" name="AppLang[]" value="{{$language->languageID}}" id="lang{{$language->languageID}}" class="langOpt" ng-checked="checkLang">
                <label for="lang{{$language->languageID}}">{{$language->languageName}}</label>
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
              @foreach ($middleware as $middleware)
              <option value="{{ $middleware->middlewareName }}">{{ $middleware->middlewareName }}</option>
              @endforeach
            </select>
          </div>

          <div class="items" style="grid-area: 8 / 1 / span 1 / span 2">
            <label>Application</label>
            <div id="app">
              <input type="radio" value="url" name="appType" id="opt1" class="opt" ng-click="radioType('url')" checked>
              <label for="opt1">URL</label>
              <input type="radio" value="file" name="appType" id="opt2" class="opt" ng-click="radioType('text')">
              <label for="opt2">File</label>
            </div>
            <i id="AppExecutable" class="fa-solid fa-file-arrow-up inputFileIcon" ng-show="displayIcon"></i>
            <input id="aePath" type="[{inputType}]" name="aePath" required  ng-show="displayInput" ng-model="aeInput">
          </div>
          <div class="items" style="grid-area: 8 / 3 / span 1 / span 2">
            <label>Documentation</label>
            <i id="Documentation" class="fa-solid fa-file-arrow-up inputFileIcon"></i>
						<input id="docPath" type="text" name="docPath" required  style="display: none" ng-model="docInput">
          </div>
          <div class="items" style="grid-area: 8 / 5 / span 1 / span 2">
            <label>Code source</label>
						<i id="SourceCode" class="fa-solid fa-file-arrow-up inputFileIcon"></i>
						<input id="scPath" type="text" name="scPath" required style="display: none" ng-model="scInput">
          </div>

          <div class="items" style="grid-area: 9 / 1 / span 1 / span 6">
            <label>Description</label>
            <textarea name="AppDesc" id="" ng-model="descirptionInput"></textarea>
          </div>

          <div class="items" style="grid-area: 10 / 1 / span 1 / span 6">
            <label>logo de l'application</label>
            <input type="file" name="AppImg" onchange="angular.element(this).scope().SelectImg(event)" id="uploadImg" accept=".jpg, .jpeg, .png, .svg">
            <div>
              <label for="uploadImg" class="fa-solid fa-square-plus imgIcon"></label>
              <i ng-click="delImg()" class="fa-solid fa-square-minus imgIcon"></i>
            </div>
            <img ng-src="[{PreviewImage}]" id="PreviewImage" ng-show="imgDiplay" >
          </div>
        </div>
        <button type="submit">Ajouter</button>
      </form>
    </main>

    {{-- cette section concerne l'affchage du porcentage du telechargement des fichiers (application executable, documentation et code source) --}}
    <div id="uploadBarMmodal" style="display: none">
			<div id="modelContainer">
				<div id="Progress_Status">
					<progress id="progressBar" max="100" value="90"></progress>
					<div id="progressValue"></div>
				</div>
			</div>
		</div>

    <script src="/js//angular/angular.min.js"></script>
		<script src="/js/resumable/resumable.min.js"></script>
    <script src="/js/addApp.js"></script>
  </body>
</html>