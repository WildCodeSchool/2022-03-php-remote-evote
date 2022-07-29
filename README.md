# EVOTE - Kit de démarrage - Symfony

## Présentation

Bienvenue sur Evote
Cet outil permet d'organiser un vote électronique facilement.
Créez une campagne de votes en cliquant sur le bouton « Créer une campagne de votes », renseignez le nom de votre campagne, sa description et ajoutez éventuellement des collèges de vote.
Ajoutez des propositions en cliquant sur le bouton « Ajouter une proposition », vos participants pourront se prononcer pour, contre ou s'abstenir. D'autres modes de vote sont actuellement à l'étude. Ajoutez des votants en cliquant sur le bouton « Ajouter un votant », définissez la pondération du vote (le nombre de voix de chaque votant), renseignez l'adresse mail sur laquelle le votant recevra son lien de vote personnel. Accédez aux résultats du vote via le bouton « Résultats ». Vous ne verrez pas les résultats nominativement, mais uniquement les résultats globaux.


## Démarrer 

### Prérequis

1. Vérifier que composer est installé
2. Vérifier que yarn & node sont installés

### Installation

1. Cloner le projet
2. Lancer `composer install`
3. Lancer `yarn install`
4. Lancer `yarn encore dev` pour construire les assets
5. Lancer `symfony server:start` pour démarrer votre serveur web php local 
6. Lancer `yarn run dev --watch` pour démarrer votre serveur web php local pour les assets (ou `yarn dev-server` qui fait la même chose avec l'activation du Hot Module Reload)

### Test

1. Lancer `php ./vendor/bin/phpcs` pour démarrer PHP code sniffer
2. Lancer `php ./vendor/bin/phpstan analyse src --level max` pour démarrer PHPStan
3. Lancer `php ./vendor/bin/phpmd src text phpmd.xml` pour démarrer PHP Mess Detector
4. Lancer `./node_modules/.bin/eslint assets/js` pour démarrer ESLint JS linter

### Utilisateurs de Windows

Si vous développez sous Windows, vous devez modifier votre configuration git pour changer les régles de fin de ligne avec cette commande : 

`git config --global core.autocrlf true`

Le fichier `.editorconfig` le fait pour vous. Si votre IDE est VSCode, vous aurez probablement besoin de l'extension `EditorConfig`.

### Démarrer en local avec Docker

1. Mettre à jour la variable DATABASE_URL dans le fichier .env.local avec
`DATABASE_URL="mysql://root:password@database:3306/<choose_a_db_name>"`
2. Installer Docker Desktop et lancer la commande :
```bash
docker-compose up -d
```
3. Attendre un instant et se rendre sur http://localhost:8000


## Déploiment

Some files are used to manage automatic deployments (using tools as Caprover, Docker and Github Action). Please do not modify them.

* [captain-definition](/captain-definition) Caprover entry point
* [Dockerfile](/Dockerfile) Web app configuration for Docker container
* [docker-entry.sh](/docker-entry.sh) shell instruction to execute when docker image is built
* [nginx.conf](/ginx.conf) Nginx server configuration
* [php.ini](/php.ini) Php configuration


## Construit avec

* [Symfony](https://github.com/symfony/symfony)
* [GrumPHP](https://github.com/phpro/grumphp)
* [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
* [PHPStan](https://github.com/phpstan/phpstan)
* [PHPMD](http://phpmd.org)
* [ESLint](https://eslint.org/)
* [Sass-Lint](https://github.com/sasstools/sass-lint)


## Contribution

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.


## Auteurs

Wild Code School trainers team


## Licence

MIT License

Copyright (c) 2019 aurelien@wildcodeschool.fr

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.


## Prise en main de l'application Evote

### Connexion

Renseigner l'un des identifiants de connexion pré-enregistrés : 

- Mél : admin@wcs.com / Mot de passe : password 
ou
- Mél : user@wcs.com / Mot de passe : password

### Créer une campagne de vote 

1. Cliquer sur "Créer une campagne de vote"
2. Renseigner les champs du formulaire
3. Cocher la case "Collège" si la campagne intègre des collèges
4. Valider et se rendre sur le tableau de bord pour accéder à la campagne créée

### Tableau de bord

Il permet de visualiser l'ensemble des campagnes de vote enregistrées et d'accéder aux détails de chacune des campagnes : 
- Administration de la campagne 
- Liste des participants 
- Liste des collèges
- Liste des résolutions
- Les résultats

### Résultats

Il permet de visualiser l'ensemble des campagnes de vote enregistrées et d'accéder aux résultats de chaque campagne. 

### Administration de la campagne

Accessible depuis le tableau de bord, il permet de paramétrer la campagne de vote : 
- Ajouter/Gérer des collèges
- Ajouter/Gérer des votants
- Ajouter/Gérer des résolutions
- Activer/Désactiver la campagne de vote
- Consulter les résultats

### Ajouter, modifier ou supprimer un collège

1. Cliquer sur "Ajouter un collège" (accessible depuis la page Administration de la campagne)
2. Renseigner les champs du formulaire
3. Valider => redirection sur la page "Gérer les collèges" affichant les collèges enregistrés sur la campagne
4. Modifier ou supprimer => Depuis la page "Gérer les collèges"

### Ajouter, modifier ou supprimer un votant

1. Cliquer sur "Ajouter un votant" (accessible depuis la page Administration de la campagne)
2. Renseigner les champs du formulaire
3. Valider => redirection sur la page "Gérer les votants" affichant les votants enregistrés sur la campagne
4. Modifier ou supprimer => Depuis la page "Gérer les votants"

### Ajouter, modifier ou supprimer une résolution

1. Cliquer sur "Ajouter une résolution" (accessible depuis la page Administration de la campagne)
2. Renseigner les champs du formulaire
3. Valider => redirection sur la page "Gérer les résolutions" affichant les résolutions enregistrées sur la campagne
4. Modifier ou supprimer => Depuis la page "Gérer les résolutions"

### Ajouter des votants en masse

1. Cliquer sur "Ajouter des votants en masse" (accessible depuis la page Administration de la campagne)
2. Télécharger la trame csv
3. Remplir le fichier csv
4. Uploader le fichier csv
3. Valider => redirection sur la page "Gérer les votants" affichant les votants enregistrées sur la campagne
4. Modifier ou supprimer => Depuis la page "Gérer les votants"

### Accéder à l'interface de vote 

1. Se rendre à l'adresse : voter/43210
2. Cliquer sur "Démarrer"
3. Voter


## MODELISATION DE LA BDD DISPO DANS LE FICHIER DOCS

## Issues connues

Interface de vote 

- [ ] faire la sécurisation des routes

Mode de calcul des pourcentages

- [ ] correction sur l'algo sur la prise en compte d'un pourcentage supérieur a 50
- [ ] pour une application d'un coef de pondération prenant en compte le poid du collège décommenter les lignes dans l'algo des collèges

Page de connexion

- [ ] Faire le back de la case a cocher  garder ma session ouverte 


Page Ajouter un votant

- [ ] Section "Pouvoir" non active (bonus)


Ensemble du site
 
- [ ] Corriger les erreurs de traductions restantes


## Future features 

- [ ] Ajouter un bouton supprimer une campagne

- [ ] Identifier l'utilisateur connecté
- [ ] Connecter une API pour pouvoir utiliser les mails en masse (le service est pour le momant limiter a un envoi de 5) 


