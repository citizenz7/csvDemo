## CSV

### Bundles
* league/csv

### Autres
* Service : src/Service/ImportCitiesService.php
* Command : src/Command/ImportCitiesCommand.php

### Résultat
Affichage de toutes les villes de la Nièvre (58) sur la Homepage

### Installation

Clonez le repo Github
`git clone https://github.com/citizenz7/csvDemo.git`

Placez-vous dans le répertoire csvDemo
`cd csvDemo`

Créez un fichier .env.local
`cp .env .env.local`

Dans .env.local, adaptez les infos pour la BDD
`DATABASE_URL="mysql://root:root@127.0.0.1:3306/csvdemo"`

Créez la base de données
`symfony console d:d:c`

Créez la migration
`symfony console make:migration`

Migrez les data dans la BDD
`symfony console d:m:m`

Intallez les bundles
`composer install`

Lancez le serveur Symfony
`symfony serve`

Rendez-vous sur : https://127.0.0.1:8000