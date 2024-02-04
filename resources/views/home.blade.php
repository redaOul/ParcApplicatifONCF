<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="shortcut icon" href="/icon/ONCForiginal.svg" />
    <link rel="stylesheet" href="/css/Home_style.css">
    <link rel="stylesheet" href="/css/navHeader_style.css">
</head>

<body>
    @include('navHeader')
    <main>
        <div id="mainContainer">
            <div id="ExploreAPP" class="items">
                <a href="ExploreApp">
                    <span>Les applications</span>
                </a>
            </div>
            <div id="ExploreAPI" class="items">
                <a href="ExploreApi">
                    <span>Les APIs</span>
                </a>
            </div>

            {{-- ces 2 elements ne s'affichent que pour les administrateurs et le super-admin --}}
            @if( (Session::get('employeeType') == 'superAdmin') || (Session::get('employeeType') == 'admin') ) 
            <div id="AddAPP" class="items">
                <a href="AddApp">
                    <span>Nouvelle App</span>
                </a>
            </div>
            <div id="AddAPI" class="items">
                <a href="AddApi">
                    <span>Nouvelle Api</span>
                </a>
            </div>
            @endif

            {{-- cet element ne s'affiche que pour le super-admin --}}
            @if( Session::get('employeeType') == 'superAdmin' )
            <div id="DashBoard" class="items lastItem">
                <a href="Dashboard">
                    <span>Table de bord</span>
                </a>
            </div>
            @endif
            
        </div>
    </main>
</body>
</html>