## Parc Applicatif

Parc Applicatif est une application Web qui permet la gestion des solutions numériques (applications et APIs) de l'ONCF Siège Central. Ce projet a été créé durant la période du stage technique de l'étudiant OULEMHOUR Reda de l'Ecole Supérieure de Technologie Kenitra de la date du 15 avril au 17 juin 2022 et qui était encadré par M. AZYEZ Mourad.

## Objectif du projet

L'ONCF à travers ses efforts importants pour suivre le rythme de l'évolution technologique, il est devant une diversité de solutions informatiques susceptibles d’être exploitées pour la bonne marche de ses services vis à vis des clients. Néanmoins, ce nombre important de solutions informatiques présente la problématique de l’ONCF, il convient donc de les organiser afin d'éviter toute perte de temps et d'efforts.

D’où vient le sujet proposé par les encadrants de l’ONCF c’est l’établissement d’un système qui centralise toutes leurs solutions informatiques et de tirer le meilleur parti des expériences stockées dans leurs versions précédentes. Donc le but du stage était le développement d’un parc applicatif ‘site Web’ From Scratch permettant la gestion des solutions numériques (applications et APIs) de l’ONCF en utilisant des interfaces graphiques qui sont claires pour faciliter l’utilisation des différentes fonctionnalités de ce projet.

## Architecture du projet

Ce projet adopte le principe MVC (Modèle-Vue-Contrôleur):

- Les modèles sont placés dans le chemin "app/Models".
  - Les fichiers de migration sont placés dans le chemin "database/migrations".
  - Le fichier qui contient des données du test est dans le chemin "databse/seeders/allTabsSeeder.php".
- Les vues sont placées dans le dossier libellé "views".
  - Les fichiers de mise en page (CSS), JavaScript, images publiques sont placés dans le dossier libellé "public".
- Les contrôleurs sont placés dans le chemin "app/Http/Controllers".
  - Le fichier qui fait la liaison entre les liens demandés et les méthodes de différents contrôleurs à exécuter est dans le chemin suivant "routes/web.php".

**NB:**
    Chaque fichier contient des commentaires décrivant chaque méthode.
    Le projet est en cours de production, et il a encore besoin de certaines fonctionnalités pour être complété.

## Compétences requises

- Développement Web
- AngularJS
- Laravel
- Application Programming Interfaces (API)
- Unified Modeling Language (UML)

## Installation

Pour installer le projet, vous devez suivre les étapes suivantes:

- Cloner le dépôt GitHub du projet sur votre machine locale.
- Installer les dépendances nécessaires avec la commande `composer install`.
- Configurer les paramètres de connexion à la base de données dans le fichier `.env`.
- Créer les tables de la base de données avec la commande `php artisan migrate`.
- Remplir les tables avec des données de test avec la commande `php artisan db:seed`.
- Lancer le serveur avec la commande `php artisan serve`.
- Ouvrir votre navigateur et accéder à l'adresse `http://localhost:8000`.

## Utilisation

Pour utiliser le projet, vous devez vous connecter avec un compte administrateur ou utilisateur. Vous pouvez utiliser les identifiants suivants:

- Administrateur: email: admin@admin.com, mot de passe: admin
- Utilisateur: email: user@user.com, mot de passe: user

En fonction de votre rôle, vous aurez accès aux différentes fonctionnalités du site:

- Page d'accueil: Cette page rassemble tous les liens vers les pages que le super-admin peut visiter, chaque acteur (super-admin, admin, utilisateur) dispose d'un certain nombre de fonctions qu'il est autorisé à utiliser.
- Page de détail: Elle affiche les informations détaillées des applications ou des APIs, ainsi que les versions, les documents et les commentaires associés.
- Page de création: Elle permet à l'utilisateur de créer une nouvelle application ou une nouvelle API ou une nouvelle version d’une application ou une API qui existe déjà, en renseignant les informations nécessaires et en téléversant les fichiers correspondants.
- Page de modification: Elle permet à l'utilisateur de modifier une application ou une API qu'il a créée, en changeant les informations ou en ajoutant des versions, des documents ou des commentaires.
- Page de table de bord: Elle n’est accessible que pour le super-admin. Grâce à cette page, il peut effectuer toutes ses tâches, telles que la modification des applications ou APIs, la modification des administrateurs et la modification des données de la BD.

## Contribution

Si vous souhaitez contribuer au projet, vous pouvez nous contacter par email à oulemhourreda@gmail.com. Nous apprécions toute suggestion, feedback ou correction de bug.

## Licence

Ce projet est sous licence Educational Community License v2.0.
