<nav>
    <a href="/Accueil"><img id="logo" src="/icon/ONCForiginal.svg"></a>
    <span id="user">
        <span>{{ Session::get('employeeName') }}</span>
        <form action="/contollers/logout" method="post">
            @csrf
            {{-- c'est le bouton qui permet de detruire la session et etre rederiger vers la page d'authentification --}}
            <button type="submit" name='logOut'>Déconnexion</button>
        </form>
    </span>
</nav>
